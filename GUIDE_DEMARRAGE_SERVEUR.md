# Guide de démarrage du serveur Laravel

## ⚠️ IMPORTANT : Le serveur doit être lancé pour accéder à l'application

Si vous voyez l'erreur **"ERR_CONNECTION_REFUSED"**, c'est parce que le serveur Laravel n'est pas lancé.

## 📋 Méthode 1 : Utiliser le fichier batch (RECOMMANDÉ)

1. **Ouvrez l'Explorateur de fichiers Windows**
2. **Naviguez vers** : `C:\Users\LANDING DIALLO\Desktop\Projects\cegme\cegme`
3. **Double-cliquez** sur le fichier `start-server.bat`
4. **Une fenêtre de terminal s'ouvrira** avec le serveur qui démarre
5. **Vous verrez** : `Laravel development server started: http://127.0.0.1:8000`
6. **LAISSEZ CETTE FENÊTRE OUVERTE** pendant que vous utilisez l'application

## 📋 Méthode 2 : Lancer manuellement dans PowerShell

1. **Ouvrez PowerShell** (clic droit → "Ouvrir PowerShell ici" dans le dossier du projet)
2. **Exécutez** :
   ```powershell
   php artisan serve
   ```
3. **Vous verrez** : `Laravel development server started: http://127.0.0.1:8000`
4. **LAISSEZ CE TERMINAL OUVERT** pendant que vous utilisez l'application

## 📋 Méthode 3 : Utiliser le script PowerShell

1. **Ouvrez PowerShell** dans le dossier du projet
2. **Exécutez** :
   ```powershell
   .\start-server.ps1
   ```

## 🔐 Se connecter à l'admin

Une fois le serveur lancé :

1. **Ouvrez votre navigateur** (Chrome, Firefox, Edge...)
2. **Allez sur** : `http://127.0.0.1:8000/login`
3. **Connectez-vous avec** :
   - **Email** : `admin@cegme.com`
   - **Mot de passe** : `admin123`
4. **Vous serez redirigé vers** : `http://127.0.0.1:8000/admin/dashboard`

## 🔧 Accéder aux règles de filtrage

Après connexion :
- **Liste des règles** : `http://127.0.0.1:8000/admin/filtering-rules`
- **Modifier une règle** : `http://127.0.0.1:8000/admin/filtering-rules/1/edit`
- **Créer une règle** : `http://127.0.0.1:8000/admin/filtering-rules/create`

## ⛔ Arrêter le serveur

Pour arrêter le serveur :
- **Dans la fenêtre du terminal**, appuyez sur `Ctrl + C`
- Le serveur s'arrêtera

## ❌ Si ça ne marche toujours pas

1. **Vérifiez que PHP est installé** :
   ```powershell
   php -v
   ```
   Vous devriez voir la version de PHP (ex: PHP 8.2.x)

2. **Vérifiez que vous êtes dans le bon dossier** :
   ```powershell
   cd "C:\Users\LANDING DIALLO\Desktop\Projects\cegme\cegme"
   ```

3. **Vérifiez qu'il n'y a pas d'erreur PHP** :
   ```powershell
   php artisan about
   ```

## 💡 Astuce

**Gardez toujours une fenêtre de terminal ouverte avec le serveur qui tourne** pendant que vous développez. C'est normal et nécessaire !

