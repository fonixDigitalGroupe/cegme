<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearAllPostsTagsCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-all-posts-tags-categories {--force : Force la suppression sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime tous les articles, tags et catégories de la base de données';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('Êtes-vous sûr de vouloir supprimer tous les articles, tags et catégories ? Cette action est irréversible.')) {
            $this->info('Opération annulée.');
            return 0;
        }

        $this->info('Suppression en cours...');

        // Compter les enregistrements avant suppression
        $postsCount = Post::count();
        $tagsCount = Tag::count();
        $categoriesCount = Category::count();

        // Supprimer dans l'ordre correct pour respecter les contraintes de clés étrangères
        // 1. Supprimer d'abord les posts (cela supprimera automatiquement les entrées dans post_tag grâce à onDelete('cascade'))
        DB::table('posts')->delete();
        $this->info("✓ {$postsCount} article(s) supprimé(s)");

        // 2. Supprimer les tags
        DB::table('tags')->delete();
        $this->info("✓ {$tagsCount} tag(s) supprimé(s)");

        // 3. Supprimer les catégories
        DB::table('categories')->delete();
        $this->info("✓ {$categoriesCount} catégorie(s) supprimée(s)");

        $this->info('✓ Suppression terminée avec succès !');

        return 0;
    }
}
