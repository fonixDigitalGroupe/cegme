# Guide d'Administration - CEGME

## Installation et Configuration

### 1. Exécuter les migrations

```bash
php artisan migrate
```

### 2. Créer les rôles (Admin et Éditeur)

```bash
php artisan db:seed --class=RoleSeeder
```

Ou exécuter tous les seeders :

```bash
php artisan db:seed
```

### 3. Créer le lien de stockage pour les images

```bash
php artisan storage:link
```

Cela créera un lien symbolique de `public/storage` vers `storage/app/public` pour permettre l'accès aux images uploadées.

### 4. Attribuer un rôle à un utilisateur

Pour attribuer un rôle Admin ou Éditeur à un utilisateur existant, vous pouvez :

1. Utiliser l'interface d'administration (si vous êtes déjà admin)
2. Utiliser Tinker :

```bash
php artisan tinker
```

Puis dans Tinker :

```php
$user = \App\Models\User::where('email', 'votre@email.com')->first();
$adminRole = \App\Models\Role::where('name', 'admin')->first();
$user->role_id = $adminRole->id;
$user->save();
```

## Accès à l'Administration

### Routes d'administration

- **Tableau de bord** : `/admin/dashboard`
- **Gestion des utilisateurs** (Admin uniquement) : `/admin/users`
- **Gestion des articles** : `/admin/posts`
- **Gestion des catégories** : `/admin/categories`
- **Gestion des tags** : `/admin/tags`

### Permissions

- **Admin** : Accès complet à toutes les fonctionnalités (utilisateurs, articles, catégories, tags)
- **Éditeur** : Accès uniquement aux articles, catégories et tags (pas de gestion des utilisateurs)

## Fonctionnalités

### Gestion des Utilisateurs (Admin uniquement)

- Créer, modifier et supprimer des utilisateurs
- Attribuer des rôles (Admin, Éditeur)
- Modifier les mots de passe

### Gestion des Articles/Blog

- **Création** : Créer de nouveaux articles avec titre, contenu, extrait
- **Modification** : Modifier les articles existants
- **Suppression** : Supprimer des articles
- **Images** : Upload d'images mises en avant pour les articles
- **Statuts** : Brouillon, Publié, Archivé
- **Catégories** : Associer des articles à des catégories
- **Tags** : Associer plusieurs tags à un article

### Gestion des Catégories

- Créer, modifier et supprimer des catégories
- Une catégorie ne peut pas être supprimée si elle contient des articles

### Gestion des Tags

- Créer, modifier et supprimer des tags
- Les tags peuvent être associés à plusieurs articles

## Structure de la Base de Données

### Tables créées

- `roles` : Rôles (admin, editor)
- `users` : Utilisateurs avec `role_id`
- `posts` : Articles du blog
- `categories` : Catégories d'articles
- `tags` : Tags pour les articles
- `post_tag` : Table pivot pour la relation many-to-many entre posts et tags

## Notes Importantes

1. **Premier utilisateur Admin** : Après avoir créé les rôles, vous devez manuellement attribuer le rôle Admin à votre premier utilisateur (via Tinker ou directement en base de données).

2. **Stockage des images** : Les images uploadées sont stockées dans `storage/app/public/posts/` et accessibles via `/storage/posts/filename.jpg` après avoir créé le lien symbolique.

3. **Sécurité** : Toutes les routes d'administration sont protégées par des middlewares qui vérifient les rôles des utilisateurs.

4. **Slugs** : Les slugs sont générés automatiquement à partir des titres/noms si non fournis, mais peuvent être personnalisés.

## Prochaines Étapes

Pour utiliser le système :

1. Exécutez les migrations et seeders
2. Créez le lien de stockage
3. Attribuez le rôle Admin à votre compte utilisateur
4. Connectez-vous et accédez à `/admin/dashboard`
5. Commencez à créer des articles, catégories et tags !


