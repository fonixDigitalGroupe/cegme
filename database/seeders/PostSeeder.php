<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create categories
        $geologieCategory = Category::firstOrCreate(
            ['slug' => 'geologie'],
            ['name' => 'Géologie', 'description' => 'Articles sur la géologie']
        );

        $environnementCategory = Category::firstOrCreate(
            ['slug' => 'environnement'],
            ['name' => 'Environnement', 'description' => 'Articles sur l\'environnement']
        );

        $minesCategory = Category::firstOrCreate(
            ['slug' => 'mines'],
            ['name' => 'Mines', 'description' => 'Articles sur les mines']
        );

        // Get or create tags
        $explorationTag = Tag::firstOrCreate(['slug' => 'exploration'], ['name' => 'Exploration']);
        $geologieTag = Tag::firstOrCreate(['slug' => 'geologie'], ['name' => 'Géologie']);
        $minesTag = Tag::firstOrCreate(['slug' => 'mines'], ['name' => 'Mines']);
        $environnementTag = Tag::firstOrCreate(['slug' => 'environnement'], ['name' => 'Environnement']);
        $centrafriqueTag = Tag::firstOrCreate(['slug' => 'centrafrique'], ['name' => 'Centrafrique']);

        // Get first user (admin)
        $user = User::first();

        if (!$user) {
            $this->command->warn('No user found. Please create a user first.');
            return;
        }

        // Default image URLs (using placeholder images)
        $defaultFeaturedImage = 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800';
        $defaultHeaderImage = 'https://images.unsplash.com/photo-1516975080664-ed2fc6a13737?w=1200';

        // Post 1: Exploration géologique
        $post1 = Post::firstOrCreate(
            ['slug' => 'exploration-geologique-nouvelles-decouvertes-en-centrafrique'],
            [
                'title' => 'Exploration géologique : Nouvelles découvertes en Centrafrique',
                'excerpt' => 'Les récentes campagnes d\'exploration géologique menées par le CEGME révèlent un potentiel minier prometteur dans plusieurs régions du pays.',
                'content' => '<h2>Campagne d\'exploration 2024</h2>
                <p>Le CEGME a conduit plusieurs missions d\'exploration géologique dans différentes régions de la République Centrafricaine, utilisant des technologies de pointe pour identifier les ressources minérales potentielles.</p>
                
                <h3>Méthodologies utilisées</h3>
                <ul>
                    <li>Levés géophysiques avancés</li>
                    <li>Échantillonnage géochimique systématique</li>
                    <li>Cartographie numérique SIG</li>
                    <li>Analyse de données satellitaires</li>
                </ul>
                
                <h3>Zones prospectées</h3>
                <p>Nos équipes ont travaillé dans les régions de Bossangoa, Gaga Yaloké et d\'autres zones à fort potentiel géologique. Les résultats préliminaires sont très encourageants et ouvrent de nouvelles perspectives pour le développement minier responsable.</p>
                
                <h3>Perspectives</h3>
                <p>Ces découvertes ouvrent de nouvelles opportunités pour le développement responsable du secteur minier centrafricain, tout en respectant les normes environnementales les plus strictes.</p>',
                'featured_image' => $this->downloadImage($defaultFeaturedImage, 'posts/featured-1.jpg'),
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => $geologieCategory->id,
                'published_at' => now()->subDays(5),
            ]
        );
        $post1->tags()->sync([$explorationTag->id, $geologieTag->id, $centrafriqueTag->id]);

        // Post 2: Étude d'impact environnemental
        $post2 = Post::firstOrCreate(
            ['slug' => 'etude-impact-environnemental-projet-hydroelectrique'],
            [
                'title' => 'CEGME réalise une étude d\'impact majeure pour un projet hydroélectrique',
                'excerpt' => 'Notre équipe a mené à bien une étude d\'impact environnemental et social approfondie pour la construction d\'une centrale hydroélectrique sur la rivière Lobaye.',
                'content' => '<h2>Étude d\'impact environnemental et social</h2>
                <p>Le CEGME a été mandaté pour réaliser une étude complète d\'impact environnemental et social pour un projet hydroélectrique majeur en République Centrafricaine.</p>
                
                <h3>Méthodologie</h3>
                <p>L\'étude a été réalisée selon les standards internationaux, incluant une analyse approfondie de l\'écosystème local, des communautés affectées et des impacts potentiels sur la biodiversité.</p>
                
                <h3>Résultats</h3>
                <p>Les résultats de l\'étude ont permis d\'identifier les mesures d\'atténuation nécessaires et de proposer un plan de gestion environnementale adapté au contexte local.</p>',
                'featured_image' => $this->downloadImage($defaultFeaturedImage, 'posts/featured-2.jpg'),
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => $environnementCategory->id,
                'published_at' => now()->subDays(10),
            ]
        );
        $post2->tags()->sync([$environnementTag->id, $centrafriqueTag->id]);

        // Post 3: Formation HSE
        $post3 = Post::firstOrCreate(
            ['slug' => 'formation-hse-entreprises-minieres'],
            [
                'title' => 'Formation HSE : Renforcer les compétences des entreprises minières',
                'excerpt' => 'Le CEGME a organisé une série de formations sur les fondamentaux du management HSE pour les entreprises du secteur minier en Centrafrique.',
                'content' => '<h2>Programme de formation HSE</h2>
                <p>Dans le cadre de son engagement pour la sécurité et la protection de l\'environnement, le CEGME a organisé un programme complet de formation en Hygiène, Sécurité et Environnement (HSE) destiné aux entreprises minières.</p>
                
                <h3>Contenu de la formation</h3>
                <ul>
                    <li>Gestion des risques professionnels</li>
                    <li>Protection de l\'environnement</li>
                    <li>Normes et réglementations</li>
                    <li>Bonnes pratiques sectorielles</li>
                </ul>
                
                <h3>Impact</h3>
                <p>Cette initiative contribue à renforcer les capacités locales et à promouvoir des pratiques minières responsables et durables.</p>',
                'featured_image' => $this->downloadImage($defaultFeaturedImage, 'posts/featured-3.jpg'),
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => $minesCategory->id,
                'published_at' => now()->subDays(15),
            ]
        );
        $post3->tags()->sync([$minesTag->id, $environnementTag->id]);

        $this->command->info('Posts seeded successfully!');
    }

    /**
     * Download an image from URL and store it locally
     */
    private function downloadImage(string $url, string $path): ?string
    {
        try {
            $response = Http::timeout(10)->get($url);
            
            if ($response->successful()) {
                Storage::disk('public')->put($path, $response->body());
                return $path;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download image from {$url}: " . $e->getMessage());
        }

        return null;
    }
}

