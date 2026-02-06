# Guide de Déploiement - CEGME

Ce document explique comment déployer correctement l'application CEGME sur un serveur de production.

## 📋 Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm (ou installation locale avec `./npm`)
- Accès SSH au serveur ou panneau de contrôle (cPanel, Plesk, etc.)

## 🚀 Étapes de Déploiement

### 1. Transférer les Fichiers

Transférez tous les fichiers du projet vers votre serveur (via FTP, Git, ou autre méthode).

```bash
# Si vous utilisez Git
git clone https://github.com/votre-repo/cegme.git
cd cegme
```

### 2. Configuration de l'Environnement

#### Copier et configurer le fichier .env

```bash
cp .env.example .env
nano .env  # ou vim, ou éditez via l'interface de votre hébergeur
```

#### Variables importantes à configurer :

```env
# URL de production (TRÈS IMPORTANT pour les images et assets)
APP_URL=https://www.dwesta.cegme.net

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votre_base_de_donnees
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe

# Email (si nécessaire)
MAIL_MAILER=smtp
MAIL_HOST=smtp.votre-serveur.com
MAIL_PORT=587
MAIL_USERNAME=votre@email.com
MAIL_PASSWORD=votre_mot_de_passe
```

### 3. Installer les Dépendances

#### Dépendances PHP (Composer)

```bash
# Si composer est installé globalement
composer install --optimize-autoloader --no-dev

# Si vous utilisez le composer local
php composer install --optimize-autoloader --no-dev
```

#### Dépendances JavaScript (npm)

```bash
# Si npm est installé globalement
npm install
npm run build

# Si vous utilisez le npm local
./npm install
./npm run build
```

### 4. Configuration de Laravel

```bash
# Générer la clé d'application
php artisan key:generate

# Nettoyer et optimiser le cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécuter les migrations de base de données
php artisan migrate --force
```

### 5. 🔴 ÉTAPE CRITIQUE : Créer le Lien Symbolique pour les Images

**Cette étape est ESSENTIELLE pour que les images du blog s'affichent correctement.**

#### Option A : Via SSH (Recommandé)

```bash
cd /chemin/vers/votre/projet
php artisan storage:link
```

Vous devriez voir :
```
The [public/storage] link has been connected to [storage/app/public].
```

#### Option B : Via cPanel

1. Allez dans **Gestionnaire de fichiers**
2. Naviguez vers le dossier `public` de votre projet
3. Créez un lien symbolique :
   - Nom : `storage`
   - Cible : `../storage/app/public`

#### Option C : Manuellement (si les options A et B ne fonctionnent pas)

Si votre hébergeur ne permet pas les liens symboliques, vous pouvez copier les fichiers :

```bash
# ATTENTION : Cette méthode nécessite de copier les fichiers à chaque upload
cp -r storage/app/public/* public/storage/
```

⚠️ **Note** : Cette méthode n'est pas recommandée car vous devrez répéter cette commande à chaque fois que vous uploadez de nouvelles images.

#### Vérifier que le lien symbolique fonctionne

```bash
# Vérifier que le lien existe
ls -la public/storage

# Devrait afficher quelque chose comme :
# lrwxrwxrwx 1 user user 20 Jan 26 17:46 storage -> ../storage/app/public

# Vérifier que les images sont accessibles
ls -la storage/app/public/posts/
```

### 6. Configuration des Permissions

```bash
# Donner les bonnes permissions aux dossiers de cache et storage
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Pour certains serveurs, vous pourriez avoir besoin de :
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 7. Vérification Post-Déploiement

#### Checklist de vérification :

- [ ] Le site est accessible via l'URL de production
- [ ] Les fichiers CSS et JS se chargent correctement
- [ ] **Les images du blog s'affichent** (vérifier sur `/blog`)
- [ ] La connexion à la base de données fonctionne
- [ ] Les formulaires fonctionnent

#### Tester les URLs des images :

Essayez d'accéder directement à une image de test :
```
https://www.dwesta.cegme.net/storage/posts/featured-1.jpg
```

Si l'image ne s'affiche pas :
1. Vérifiez que le lien symbolique existe : `ls -la public/storage`
2. Vérifiez que l'image existe : `ls -la storage/app/public/posts/`
3. Vérifiez les permissions : `ls -la storage/app/public/`
4. Vérifiez que `APP_URL` est correct dans `.env`

## 🔧 Dépannage

### Les images du blog ne s'affichent pas

**Symptôme** : Les cartes de blog affichent un fond gris au lieu des images.

**Solutions** :

1. **Vérifier le lien symbolique** :
   ```bash
   ls -la public/storage
   ```
   Si le lien n'existe pas, créez-le avec `php artisan storage:link`

2. **Vérifier APP_URL** :
   ```bash
   grep APP_URL .env
   ```
   Doit être `APP_URL=https://www.dwesta.cegme.net` (pas `localhost`)

3. **Nettoyer le cache** :
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

4. **Vérifier les permissions** :
   ```bash
   chmod -R 755 storage/app/public
   ```

### Les assets CSS/JS ne se chargent pas

```bash
# Rebuild les assets
./npm run build

# Vérifier que les fichiers sont dans public/build/
ls -la public/build/
```

### Erreur 500

```bash
# Activer le mode debug temporairement pour voir l'erreur
nano .env
# Changer APP_DEBUG=false en APP_DEBUG=true
# IMPORTANT : Remettre à false après avoir identifié le problème

# Voir les logs
tail -f storage/logs/laravel.log
```

## 📝 Maintenance Continue

### Mise à jour du site

```bash
# 1. Récupérer les dernières modifications
git pull origin main

# 2. Mettre à jour les dépendances si nécessaire
composer install --optimize-autoloader --no-dev
./npm install
./npm run build

# 3. Exécuter les nouvelles migrations
php artisan migrate --force

# 4. Nettoyer le cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Backup

N'oubliez pas de sauvegarder régulièrement :
- La base de données
- Le dossier `storage/app/public` (contient toutes les images uploadées)
- Le fichier `.env`

## 🆘 Support

Si vous rencontrez des problèmes qui ne sont pas couverts dans ce guide, vérifiez :
1. Les logs Laravel : `storage/logs/laravel.log`
2. Les logs du serveur web (Apache/Nginx)
3. Les permissions des fichiers et dossiers
