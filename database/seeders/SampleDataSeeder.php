<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 5 catégories
        $categories = [
            ['name' => 'Géologie', 'description' => 'Articles sur la géologie et les sciences de la terre'],
            ['name' => 'Mines', 'description' => 'Articles sur l\'exploitation minière et les ressources minérales'],
            ['name' => 'Environnement', 'description' => 'Articles sur la protection de l\'environnement'],
            ['name' => 'Recherche', 'description' => 'Articles de recherche scientifique'],
            ['name' => 'Actualités', 'description' => 'Actualités et nouvelles du secteur'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        }

        // Créer 5 tags
        $tags = [
            ['name' => 'Centrafrique'],
            ['name' => 'Exploration'],
            ['name' => 'Développement durable'],
            ['name' => 'Études d\'impact'],
            ['name' => 'Innovation'],
        ];

        $createdTags = [];
        foreach ($tags as $tag) {
            $createdTags[] = Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
            ]);
        }

        // Récupérer un utilisateur admin ou créer un article avec le premier utilisateur
        $user = User::where('email', 'admin@cegme.com')->first() ?? User::first();

        if (!$user) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez créer un utilisateur d\'abord.');
            return;
        }

        // Créer 5 articles
        $articles = [
            [
                'title' => 'Exploration géologique en République Centrafricaine',
                'excerpt' => 'Une étude approfondie des ressources géologiques disponibles dans la région.',
                'content' => 'La République Centrafricaine possède d\'importantes ressources géologiques qui nécessitent une exploration approfondie. Cet article présente les dernières découvertes et les méthodes d\'exploration utilisées par CEGME.',
                'status' => 'published',
                'category_id' => $createdCategories[0]->id,
                'tags' => [$createdTags[0]->id, $createdTags[1]->id],
            ],
            [
                'title' => 'Impact environnemental des activités minières',
                'excerpt' => 'Analyse des impacts environnementaux et mesures de mitigation.',
                'content' => 'Les activités minières peuvent avoir des impacts significatifs sur l\'environnement. CEGME propose des solutions durables pour minimiser ces impacts tout en permettant le développement économique.',
                'status' => 'published',
                'category_id' => $createdCategories[2]->id,
                'tags' => [$createdTags[2]->id, $createdTags[3]->id],
            ],
            [
                'title' => 'Nouvelles techniques d\'exploration minière',
                'excerpt' => 'Innovations technologiques dans le domaine de l\'exploration.',
                'content' => 'Les technologies d\'exploration minière évoluent rapidement. Cet article présente les dernières innovations et leur application dans le contexte centrafricain.',
                'status' => 'published',
                'category_id' => $createdCategories[1]->id,
                'tags' => [$createdTags[1]->id, $createdTags[4]->id],
            ],
            [
                'title' => 'Recherche sur les ressources minérales',
                'excerpt' => 'Études récentes sur les gisements minéraux en Centrafrique.',
                'content' => 'CEGME mène des recherches approfondies sur les ressources minérales de la République Centrafricaine. Cet article présente les résultats de nos dernières études.',
                'status' => 'draft',
                'category_id' => $createdCategories[3]->id,
                'tags' => [$createdTags[0]->id, $createdTags[1]->id],
            ],
            [
                'title' => 'Actualités du secteur minier centrafricain',
                'excerpt' => 'Dernières nouvelles et développements dans le secteur minier.',
                'content' => 'Retrouvez les dernières actualités du secteur minier en République Centrafricaine, les nouveaux projets et les partenariats stratégiques.',
                'status' => 'published',
                'category_id' => $createdCategories[4]->id,
                'tags' => [$createdTags[0]->id, $createdTags[2]->id],
            ],
        ];

        foreach ($articles as $article) {
            $tags = $article['tags'];
            unset($article['tags']);

            $post = Post::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'excerpt' => $article['excerpt'],
                'content' => $article['content'],
                'status' => $article['status'],
                'category_id' => $article['category_id'],
                'user_id' => $user->id,
                'published_at' => $article['status'] === 'published' ? now() : null,
            ]);

            $post->tags()->sync($tags);
        }

        $this->command->info('5 catégories, 5 tags et 5 articles créés avec succès !');
    }
}
