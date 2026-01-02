# Vérification et Traçabilité des Dates Limites

## 📋 Comment les dates limites sont récupérées

### Pour World Bank

Le système utilise **3 sources prioritaires** pour récupérer les dates limites :

#### 1. **API World Bank (Priorité 1) - Source la plus fiable**
- **Champ API** : `submission_deadline_date`
- **Où** : Dans la réponse JSON de l'API `https://search.worldbank.org/api/v2/procnotices`
- **Format** : Peut être un timestamp Unix (millisecondes ou secondes) ou une chaîne de caractères
- **Preuve** : Les logs contiennent `"source": "API (submission_deadline_date)"`

#### 2. **Page de Notice HTML (Priorité 2) - Si l'API ne fournit pas la date**
- **URL** : La page de notice World Bank (ex: `https://projects.worldbank.org/en/projects-operations/procurement/notice/...`)
- **Méthodes de recherche** :
  - **Méthode A** : Recherche dans les tableaux HTML avec les labels :
    - "Submission Deadline"
    - "Deadline for Submission"
    - "Closing Date"
    - "Date limite de soumission"
  - **Méthode B** : Recherche près des mots-clés dans le texte HTML
  - **Méthode C** : Extraction de toutes les dates et sélection de la plus récente
- **Preuve** : Les logs contiennent `"source": "Page HTML - ..."` avec l'extrait HTML trouvé

#### 3. **Fallback** : Si aucune date n'est trouvée
- La date limite reste `NULL`
- Un avertissement est loggé avec les raisons possibles

---

## 🔍 Où trouver les preuves

### 1. **Dans les logs Laravel**

Fichier : `storage/logs/laravel.log`

Recherchez les entrées avec :
- `World Bank Scraper: ✅ Date récupérée depuis...`
- `[WB] RÉSUMÉ | Date limite de soumission`

**Exemple de log pour une date depuis l'API** :
```json
{
  "message": "World Bank Scraper: ✅ Date récupérée depuis l'API",
  "source": "API (submission_deadline_date)",
  "raw_value": "1735689600",
  "normalized": "2025-01-01",
  "project_id": "P123456",
  "notice_url": "https://...",
  "titre": "Project Title"
}
```

**Exemple de log pour une date depuis la page HTML** :
```json
{
  "message": "World Bank Scraper: ✅ Date récupérée depuis la page HTML (tableau)",
  "source": "Page HTML - Tableau avec label",
  "url": "https://projects.worldbank.org/.../notice/...",
  "label_trouve": "Submission Deadline",
  "texte_brut": "January 15, 2025",
  "date_normalisee": "2025-01-15",
  "methode": "XPath: th/td avec label"
}
```

### 2. **Commande de vérification**

Utilisez la commande dédiée pour vérifier les dates :

```bash
# Vérifier toutes les offres récentes
php artisan app:verify-deadline-dates

# Vérifier une source spécifique
php artisan app:verify-deadline-dates --source="World Bank"

# Limiter le nombre d'offres
php artisan app:verify-deadline-dates --limit=5
```

Cette commande affiche :
- ✅ Les offres avec date limite et leur source
- ❌ Les offres sans date limite avec les raisons possibles
- 📊 Statistiques de récupération

### 3. **Fichiers HTML de debug (si activé)**

Si `APP_DEBUG=true` dans `.env`, les pages HTML sont sauvegardées dans :
- `storage/app/debug/wb_notice_[hash].html` - Pages de notice
- `storage/app/debug/worldbank_project_[id].html` - Pages de projet

---

## ✅ Comment vérifier qu'une date est correcte

### Vérification manuelle

1. **Récupérer l'URL de l'offre** depuis la base de données
2. **Ouvrir la page de notice** dans un navigateur
3. **Chercher le label** "Submission Deadline" ou "Date limite de soumission"
4. **Comparer la date** affichée avec celle dans la base de données

### Vérification automatique

1. **Consulter les logs** pour voir la source de la date
2. **Si source = API** : La date provient directement de l'API World Bank (très fiable)
3. **Si source = Page HTML** : Vérifier l'extrait HTML dans les logs pour confirmer

---

## 📊 Statistiques de récupération

Pour voir le taux de récupération des dates :

```bash
php artisan app:test-active-sources-scraping
```

Cette commande affiche :
- Le nombre d'offres scrapées
- Le pourcentage d'offres avec date limite
- Des exemples d'offres sans date limite

---

## 🔧 Amélioration de la récupération

Si des dates ne sont pas récupérées, vérifiez :

1. **L'API retourne-t-elle `submission_deadline_date` ?**
   - Vérifier dans les logs si `"source": "API"` apparaît
   - Si non, l'API ne fournit pas cette information

2. **La page de notice est-elle accessible ?**
   - Vérifier que `notice_url` n'est pas vide
   - Tester l'URL dans un navigateur

3. **Le format de date est-il reconnu ?**
   - Les formats supportés sont listés dans `normalizeDateString()`
   - Formats : "January 15, 2025", "15/01/2025", "2025-01-15", etc.

4. **Le label existe-t-il dans la page ?**
   - Chercher "Submission Deadline", "Closing Date", etc.
   - Vérifier dans le HTML sauvegardé (si debug activé)

---

## 📝 Format des dates normalisées

Toutes les dates sont normalisées au format **YYYY-MM-DD** (ISO 8601) :
- `2025-01-15` = 15 janvier 2025
- `2025-12-31` = 31 décembre 2025

Les formats d'entrée acceptés :
- `January 15, 2025` (anglais)
- `15 janvier 2025` (français)
- `15/01/2025` (format court)
- `2025-01-15` (ISO)
- `15-Jan-2025` (format abrégé)

---

## 🎯 Résumé

| Source | Fiabilité | Preuve |
|--------|-----------|--------|
| API World Bank | ⭐⭐⭐⭐⭐ Très élevée | Logs avec `"source": "API"` |
| Page HTML (tableau) | ⭐⭐⭐⭐ Élevée | Logs avec extrait HTML et label |
| Page HTML (mot-clé) | ⭐⭐⭐ Moyenne | Logs avec extrait HTML |
| Page HTML (plus récente) | ⭐⭐ Faible | Logs avec note de vérification |

**Recommandation** : Vérifier manuellement les dates récupérées via "Page HTML (plus récente)" car cette méthode est moins précise.

