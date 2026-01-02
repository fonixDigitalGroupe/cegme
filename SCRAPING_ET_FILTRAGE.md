# Système de Scraping et Filtrage des Offres

## Vue d'ensemble

Le système permet de :
1. **Scraper uniquement les sources avec des règles actives**
2. **Afficher uniquement les offres qui respectent les critères de filtrage** (type de marché, pays, mots-clés)

## Fonctionnement

### 1. Vérification des règles actives avant scraping

Les scrapers vérifient maintenant si une règle de filtrage active existe pour leur source avant de scraper :

- **ScrapeAFD** : Vérifie si une règle active existe pour "AFD"
- Si aucune règle active → le scraping ne s'exécute pas (sauf avec `--force`)
- Si une règle active existe → le scraping s'exécute normalement

### 2. Commande pour scraper toutes les sources actives

```bash
php artisan app:scrape-active-sources
```

Cette commande :
- Détecte automatiquement toutes les sources avec des règles actives
- Lance le scraping uniquement pour ces sources
- Affiche un résumé des résultats

### 3. Filtrage automatique à l'affichage

Le contrôleur `OffreController` applique automatiquement le filtrage :
- Récupère toutes les offres
- Applique les règles de filtrage actives
- Affiche uniquement les offres qui respectent :
  - Le type de marché (si spécifié dans la règle)
  - Le pays (si spécifié dans la règle)
  - Les mots-clés des pôles d'activité (si spécifiés dans la règle)

### 4. Commandes disponibles

#### Scraping d'une source spécifique
```bash
# AFD
php artisan scrape:afd

# African Development Bank
php artisan app:scrape-afdb

# World Bank
php artisan app:scrape-world-bank

# BDEAC
php artisan app:scrape-bdeac

# IFAD
php artisan app:scrape-ifad

# DGMarket
php artisan app:scrape-dgmarket

# TED
php artisan app:scrape-ted
```

#### Scraping de toutes les sources actives
```bash
php artisan app:scrape-active-sources
```

#### Tester le filtrage
```bash
php artisan app:test-filtering
```

#### Voir les règles actives
```bash
php artisan app:test-scraping-filters
```

### 5. Workflow recommandé

1. **Activer les règles de filtrage** dans l'admin (`/admin/filtering-rules`)
2. **Configurer les critères** pour chaque source :
   - Type de marché
   - Pays ciblés
   - Pôles d'activité et mots-clés
3. **Lancer le scraping** :
   ```bash
   php artisan app:scrape-active-sources
   ```
4. **Vérifier les résultats** sur la page publique (`/appels-offres`)
   - Seules les offres qui respectent les critères sont affichées

### 6. Exemple

**Configuration :**
- Règle active : "AFD - Bureau d'études Mines"
  - Source : AFD
  - Type de marché : Bureau d'études
  - Pays : Tous
  - Pôles d'activité : Aucun

**Résultat :**
- Le scraper AFD s'exécute
- Les offres AFD sont scrapées et sauvegardées
- Seules les offres de type "Bureau d'études" sont affichées sur le site

### 7. Force le scraping (ignorer la vérification)

Si vous voulez forcer le scraping même sans règle active :

```bash
php artisan scrape:afd --force
```

### 8. Notes importantes

- Les offres sont **toujours sauvegardées en base** même si elles ne passent pas le filtre
- Le filtrage s'applique uniquement à **l'affichage** (page publique)
- Si aucune règle active n'existe pour une source, le scraping ne s'exécute pas (sauf avec `--force`)
- Le filtrage utilise un système de fallback pour garantir qu'il y a toujours des offres affichées




