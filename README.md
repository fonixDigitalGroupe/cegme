# CIGME - Projet Laravel avec Authentification

Projet Laravel complet avec système d'authentification utilisant Laravel Breeze et MySQL.

## 📋 Prérequis

- PHP >= 8.2
- Composer
- Node.js et npm
- MySQL
- Extension PHP PDO MySQL

## 🚀 Installation

### 1. Cloner ou naviguer vers le projet

```bash
cd cigme
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances Node.js

```bash
npm install
```

### 4. Configuration de l'environnement

Le fichier `.env` est déjà configuré avec les paramètres suivants :
- **Base de données** : MySQL
- **Nom de la base de données** : `cigme_db`
- **Host** : `127.0.0.1`
- **Port** : `3306`
- **Username** : `root`
- **Password** : (vide par défaut, modifiez selon votre configuration)

Si nécessaire, modifiez le fichier `.env` pour ajuster les paramètres de connexion MySQL.

### 5. Créer la base de données MySQL

Connectez-vous à MySQL et créez la base de données :

```sql
CREATE DATABASE cigme_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Générer la clé d'application

```bash
php artisan key:generate
```

### 7. Exécuter les migrations

```bash
php artisan migrate
```

Cette commande créera les tables suivantes :
- `users` - Table des utilisateurs
- `password_reset_tokens` - Tokens de réinitialisation de mot de passe
- `sessions` - Sessions utilisateur

### 8. Compiler les assets (CSS/JS)

Pour le développement :
```bash
npm run dev
```

Pour la production :
```bash
npm run build
```

## 🏃 Lancer l'application

### Démarrer le serveur de développement

```bash
php artisan serve
```

L'application sera accessible à l'adresse : `http://localhost:8000`

### Ou utiliser le script dev (avec hot reload)

```bash
composer run dev
```

## 🔐 Fonctionnalités d'authentification

Le projet inclut un système d'authentification complet avec Laravel Breeze :

### Routes disponibles

- **Inscription** : `/register`
- **Connexion** : `/login`
- **Tableau de bord** : `/dashboard` (protégé)
- **Profil** : `/profile` (protégé)
- **Mot de passe oublié** : `/forgot-password`
- **Réinitialisation de mot de passe** : `/reset-password/{token}`
- **Vérification d'email** : `/verify-email`
- **Déconnexion** : `/logout` (POST)

### Fonctionnalités

✅ Inscription de nouveaux utilisateurs  
✅ Connexion/Déconnexion  
✅ Réinitialisation de mot de passe  
✅ Vérification d'email  
✅ Gestion de profil utilisateur  
✅ Protection des routes par middleware d'authentification  

## 📁 Structure du projet

```
cigme/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Auth/          # Contrôleurs d'authentification
│   └── Models/
│       └── User.php           # Modèle utilisateur
├── database/
│   └── migrations/            # Migrations de base de données
├── resources/
│   └── views/
│       ├── auth/              # Vues d'authentification
│       ├── dashboard.blade.php
│       └── layouts/           # Layouts Blade
├── routes/
│   ├── web.php               # Routes web
│   └── auth.php              # Routes d'authentification
└── .env                      # Configuration de l'environnement
```

## 🧪 Tests

```bash
php artisan test
```

## 📝 Commandes utiles

- **Nettoyer le cache** : `php artisan cache:clear`
- **Nettoyer la config** : `php artisan config:clear`
- **Créer un utilisateur** : `php artisan tinker` puis `User::create([...])`
- **Voir les routes** : `php artisan route:list`

## 🔧 Configuration MySQL

Si vous devez modifier les paramètres de connexion MySQL, éditez le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cigme_db
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

## 📚 Documentation Laravel

- [Documentation Laravel](https://laravel.com/docs)
- [Laravel Breeze](https://laravel.com/docs/breeze)

## 📄 License

Le framework Laravel est open-source sous la licence [MIT](https://opensource.org/licenses/MIT).
