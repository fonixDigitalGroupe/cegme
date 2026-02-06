# Guide de Déploiement Sécurisé vers OVH Cloud

## ✅ Pré-vérification de sécurité

Avant de déployer, vérifiez que ces fichiers ne sont PAS dans Git :
```bash
git status
```

✅ **Confirmé** : `.env` est dans `.gitignore` → Votre configuration OVH ne sera pas touchée

## 📤 Étape 1 : Sauvegarder vers GitHub

```bash
# 1. Ajouter les fichiers modifiés
git add routes/web.php
git add DEPLOYMENT.md

# 2. Créer le commit
git commit -m "Fix: Ajouter route de fallback pour images du blog + guide de déploiement"

# 3. Pousser vers GitHub
git push origin main
```

## 🚀 Étape 2 : Déployer sur OVH Cloud

### Option A : Via SSH (Recommandé)

```bash
# 1. Se connecter à votre serveur OVH
ssh votre-utilisateur@votre-serveur.ovh

# 2. Aller dans le répertoire du projet
cd /chemin/vers/votre/projet

# 3. IMPORTANT : Sauvegarder le .env actuel (au cas où)
cp .env .env.backup.$(date +%Y%m%d)

# 4. Récupérer les dernières modifications
git pull origin main

# 5. Nettoyer le cache Laravel
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# 6. Vérifier que tout fonctionne
php artisan route:list | grep storage
# Devrait afficher la nouvelle route "storage.fallback"
```

### Option B : Via FTP/SFTP

Si vous n'avez pas accès SSH :

1. **Téléchargez d'abord votre .env depuis OVH** (sauvegarde de sécurité)
2. **Transférez uniquement ces fichiers** :
   - `routes/web.php`
   - `DEPLOYMENT.md` (optionnel, c'est juste de la doc)
3. **Ne touchez PAS à :`** 
   - `.env`
   - `storage/app/public/` (vos images)
   - Base de données

4. **Via le panneau OVH ou SSH, exécutez** :
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan cache:clear
   ```

## 🔍 Étape 3 : Vérification Post-Déploiement

### 1. Vérifier que le .env n'a pas été modifié

```bash
# Sur le serveur OVH
cat .env | grep APP_URL
# Devrait afficher : APP_URL=https://www.dwesta.cegme.net (ou votre URL)
```

### 2. Vérifier que la route fonctionne

Ouvrez votre navigateur :
```
https://www.dwesta.cegme.net/blog
```

Les images devraient maintenant s'afficher ! ✨

### 3. Test de l'URL directe d'une image

```
https://www.dwesta.cegme.net/storage/posts/featured-1.jpg
```

Si cette URL fonctionne → Tout est OK !

## ⚠️ Checklist de sécurité avant déploiement

- [ ] ✅ `.env` est dans le `.gitignore`
- [ ] ✅ Sauvegarde du `.env` actuel sur OVH
- [ ] ✅ Commit uniquement `routes/web.php` et `DEPLOYMENT.md`
- [ ] ✅ Ne pas faire `git add .` (risque d'inclure des fichiers non désirés)
- [ ] ✅ Après le pull, vérifier que `.env` n'a pas changé

## 🔧 Si quelque chose ne va pas

### Scénario 1 : Le .env a été écrasé (très peu probable)

```bash
# Restaurer la sauvegarde
cp .env.backup.YYYYMMDD .env

# Recharger la config
php artisan config:clear
```

### Scénario 2 : Les images ne s'affichent toujours pas

```bash
# Vérifier les routes
php artisan route:list | grep storage

# Nettoyer tous les caches
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# Vérifier les permissions
chmod -R 755 storage/app/public
```

### Scénario 3 : Erreur 500

```bash
# Voir les logs
tail -f storage/logs/laravel.log
```

## 📋 Commandes à exécuter sur OVH (résumé)

```bash
# Connexion SSH
ssh votre-utilisateur@votre-serveur.ovh

# Navigation et backup
cd /chemin/vers/votre/projet
cp .env .env.backup.$(date +%Y%m%d)

# Mise à jour
git pull origin main

# Nettoyage du cache
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Vérification
ls -la .env
cat .env | grep APP_URL
php artisan route:list | grep storage
```

## ✨ Résultat attendu

Après le déploiement :
- ✅ Toutes vos configurations OVH restent intactes
- ✅ Les images du blog s'affichent correctement
- ✅ La nouvelle route de fallback est active
- ✅ Aucune donnée n'a été perdue

---

**Temps estimé** : 5-10 minutes  
**Complexité** : Faible  
**Risque** : Très faible (le .env est protégé par .gitignore)
