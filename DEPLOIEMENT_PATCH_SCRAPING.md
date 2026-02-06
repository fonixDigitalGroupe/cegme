# PATCH URGENT : Scraping Fonctionnel sur OVH

## 🎯 Ce qui a été modifié

**Fichier** : `app/Http/Controllers/Admin/ScrapingController.php`

**Problème résolu** : exec() et proc_open() sont désactivés sur OVH mutualisé, empêchant le scraping de fonctionner.

**Solution** : Le scraping s'exécute maintenant de manière synchrone (dans la même requête HTTP) au lieu d'essayer de lancer un processus séparé.

## 📦 Déploiement en Production (3 méthodes)

### Méthode 1 : Via GitHub + Git Pull (RECOMMANDÉ)

#### Étape 1 : Commit et Push (LOCAL)

```bash
cd "/home/fonix-sa/Bureau/Fonix projects/Cegme/cegme"

# Ajouter les modifications
git add app/Http/Controllers/Admin/ScrapingController.php

# Commit
git commit -m "Fix: Scraping synchrone pour compatibilité OVH (sans exec)"

# Push vers GitHub
git push origin main
```

#### Étape 2 : Pull sur le serveur (OVH)

**Via SSH** (si vous avez accès) :
```bash
ssh votre-utilisateur@dwesta.cegme.net
cd /chemin/vers/votre/projet

# Sauvegarder au cas où
cp -r app/Http/Controllers app/Http/Controllers.backup

# Récupérer les changements
git pull origin main

# Nettoyer le cache
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

**Via le panneau OVH** (si pas d'accès SSH) :
- Si vous avez configuré le déploiement automatique Git → Il se déploiera automatiquement
- Sinon, utilisez la Méthode 2 (FTP)

---

### Méthode 2 : Via FTP (Sans Git)

#### Étape 1 : Préparer le fichier

1. Le fichier modifié est : `app/Http/Controllers/Admin/ScrapingController.php`
2. Il se trouve dans : `/home/fonix-sa/Bureau/Fonix projects/Cegme/cegme/`

#### Étape 2 : Upload via FTP

1. **Connectez-vous au FTP** de dwesta.cegme.net
2. **Naviguez vers** : `app/Http/Controllers/Admin/`
3. **Sauvegarde** : 
   - Téléchargez d'abord `ScrapingController.php` actuel
   - Renommez-le en `ScrapingController.php.backup`
4. **Upload** :
   - Uploadez le nouveau `ScrapingController.php`
   - Écrasez l'ancien fichier

#### Étape 3 : Nettoyer le cache

Via le panneau OVH, si possible :
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

Sinon, attendez quelques minutes que le cache expire automatiquement.

---

### Méthode 3 : Copier-Coller Manuel (Dernier recours)

Si vous ne pouvez pas utiliser FTP ou Git :

1. **Via le panneau OVH** ou un éditeur de fichiers web
2. **Ouvrez** : `app/Http/Controllers/Admin/ScrapingController.php`
3. **Trouvez la méthode** `start()` (ligne 40-108)
4. **Remplacez tout le contenu** de cette méthode par le nouveau code

---

## ✅ Vérification Après Déploiement

### 1. Tester le scraping

1. Allez sur `https://www.dwesta.cegme.net/admin/scraping`
2. Cliquez sur **"Démarrer le scraping"**
3. **Résultat attendu** :
   - ✅ "Vidage de la base..." apparaît
   - ✅ Puis "Scraping de AFD..." (ou autre source)
   - ✅ Les offres commencent à apparaître
   - ✅ La progression avance normalement

### 2. Vérifier les logs

Si ça ne marche toujours pas, téléchargez le fichier :
```
storage/logs/laravel.log
```

Cherchez les lignes récentes pour voir l'erreur exacte.

### 3. Vérifier dans phpMyAdmin

1. Ouvrez phpMyAdmin
2. Sélectionnez votre base de données
3. Cliquez sur la table `offres`
4. Vérifiez que des nouvelles données apparaissent pendant le scraping

---

## ⚠️ Limitations du Mode Synchrone

### Avantages ✅
- Fonctionne sur OVH mutualisé (et tous les hébergements)
- Pas besoin d'activer exec() ou proc_open()
- Plus simple à déboguer

### Inconvénients ⚠️
- **Timeout possible** : Si le serveur limite le temps d'exécution à 60-120 secondes
- **Connexion doit rester ouverte** : Si vous fermez l'onglet pendant le scraping, ça s'arrête

### Solutions aux limitations

**Si timeout après 1-2 minutes** :

1. **Réduire le nombre de sources** scrapées simultanément
2. **Scraper source par source** manuellement :
   - Désactiver toutes les règles sauf une
   - Lancer le scraping
   - Attendre la fin
   - Activer une autre règle
   - Relancer avec "Conserver les offres existantes"

**Si vous fermez l'onglet** :
- Le scraping s'arrête
- Pas grave, relancez-le avec "Conserver les offres existantes"

---

## 🔧 Paramètres PHP Modifiés

Le patch modifie ces paramètres pendant l'exécution :

```php
set_time_limit(300); // 5 minutes maximum
ini_set('max_execution_time', '300');
```

**Note** : OVH peut avoir des limites strictes qui empêchent ces modifications.
Si le scraping timeout après 60-120 secondes, c'est normal sur un hébergement mutualisé.

---

## 💡 Alternatives si le scraping timeout

### Option A : Cron Job (Configuration OVH)

Créez une tâche planifiée dans le panneau OVH :

```bash
cd /chemin/vers/projet && php artisan schedule:run
```

Fréquence : Toutes les heures ou tous les jours

### Option B : Scraping manuel source par source

1. Allez dans "Règles de filtrage"
2. Désactivez toutes les sources sauf une
3. Lancez le scraping
4. Attendez qu'il finisse
5. Activez la source suivante
6. Relancez avec "Conserver les offres existantes" coché

---

## 📊 Différences avec votre environnement local

| Aspect | Local | Production OVH |
|--------|-------|----------------|
| exec() / proc_open() | ✅ Activé | ❌ Désactivé |
| Temps d'exécution max | ⏱️ Illimité | ⏱️ 60-120 sec |
| Processus séparés | ✅ Oui | ❌ Non |
| Mode | Asynchrone | **Synchrone** |

---

## 🎯 Résultat Attendu

Après le déploiement, au lieu de rester bloqué à "Vidage...", vous devriez voir :

```
✓ Vidage de la base de données...
✓ Scraping de AFD... 12 offres pertinentes trouvées
✓ Scraping de World Bank... 25 offres pertinentes trouvées
✓ Scraping de BDEAC... 8 offres pertinentes trouvées
...
✓ Scraping terminé - 73 offres au total
```

---

## 📝 Checklist de Déploiement

- [ ] Fichier `ScrapingController.php` modifié uploadé sur le serveur
- [ ] Cache Laravel nettoyé (`php artisan cache:clear`)
- [ ] Test du scraping effectué
- [ ] Au moins une source scrape avec succès
- [ ] Offres visibles dans phpMyAdmin et sur le site

---

**Temps de déploiement** : 5-10 minutes  
**Complexité** : Moyenne  
**Risque** : Faible (seule la fonction de scraping est modifiée)
