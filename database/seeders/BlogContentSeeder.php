<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer le premier utilisateur
        $user = User::first();

        if (!$user) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez créer un utilisateur d\'abord.');
            return;
        }

        // Créer 5 catégories
        $categories = [
            [
                'name' => 'Géologie',
                'description' => 'Articles sur la géologie, les formations rocheuses et les ressources minérales'
            ],
            [
                'name' => 'Exploitation Minière',
                'description' => 'Articles sur les techniques d\'exploitation minière et les projets miniers'
            ],
            [
                'name' => 'Environnement',
                'description' => 'Articles sur la protection de l\'environnement et le développement durable'
            ],
            [
                'name' => 'Recherche & Innovation',
                'description' => 'Articles sur les recherches scientifiques et les innovations technologiques'
            ],
            [
                'name' => 'Actualités',
                'description' => 'Actualités et nouvelles du secteur minier et géologique'
            ],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                ]
            );
        }

        $this->command->info('✓ 5 catégories créées');

        // Créer 5 tags
        $tags = [
            ['name' => 'Centrafrique'],
            ['name' => 'Exploration'],
            ['name' => 'Développement Durable'],
            ['name' => 'Études d\'Impact'],
            ['name' => 'Technologie'],
        ];

        $createdTags = [];
        foreach ($tags as $tag) {
            $createdTags[] = Tag::firstOrCreate(
                ['slug' => Str::slug($tag['name'])],
                ['name' => $tag['name']]
            );
        }

        $this->command->info('✓ 5 tags créés');

        // Images Unsplash pour featured_image et header_image
        $imageUrls = [
            'featured' => [
                'https://images.unsplash.com/photo-1516975080664-ed2fc6a13737?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=600&fit=crop',
            ],
            'header' => [
                'https://images.unsplash.com/photo-1516975080664-ed2fc6a13737?w=1200&h=400&fit=crop',
                'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1200&h=400&fit=crop',
                'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=400&fit=crop',
                'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=400&fit=crop',
                'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=400&fit=crop',
                'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1200&h=400&fit=crop',
            ],
        ];

        // Contenu des articles avec images intégrées
        $articles = [
            [
                'title' => 'Exploration géologique en République Centrafricaine : Nouvelles perspectives',
                'excerpt' => 'Découvrez les dernières avancées en matière d\'exploration géologique et les ressources minérales prometteuses identifiées par le CEGME.',
                'content' => '<h2>Introduction</h2>
                <p>La République Centrafricaine possède un potentiel géologique exceptionnel qui commence à être mieux compris grâce aux campagnes d\'exploration menées par le CEGME. Cet article présente les dernières découvertes et les méthodes innovantes utilisées pour cartographier les ressources du pays.</p>
                
                <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a13737?w=1200&h=600&fit=crop" alt="Exploration géologique" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Méthodologies d\'exploration</h3>
                <p>Nos équipes utilisent une combinaison de techniques modernes pour identifier les gisements minéraux :</p>
                <ul>
                    <li><strong>Levés géophysiques aériens</strong> : Utilisation de technologies magnétiques et électromagnétiques pour détecter les anomalies géologiques</li>
                    <li><strong>Cartographie géologique de terrain</strong> : Analyse détaillée des formations rocheuses et des structures géologiques</li>
                    <li><strong>Échantillonnage géochimique</strong> : Prélèvement et analyse d\'échantillons pour identifier les concentrations minérales</li>
                    <li><strong>Télédétection satellitaire</strong> : Utilisation d\'images satellites haute résolution pour la cartographie régionale</li>
                </ul>
                
                <h3>Zones d\'intérêt identifiées</h3>
                <p>Plusieurs régions présentent un potentiel particulièrement intéressant :</p>
                <ul>
                    <li>La région de Bossangoa pour les métaux de base</li>
                    <li>Les zones autour de Gaga Yaloké pour les métaux précieux</li>
                    <li>Les formations du nord-est pour les ressources énergétiques</li>
                </ul>
                
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1200&h=600&fit=crop" alt="Cartographie géologique" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Perspectives d\'avenir</h3>
                <p>Ces découvertes ouvrent de nouvelles perspectives pour le développement économique du pays tout en respectant les normes environnementales les plus strictes. Le CEGME continue d\'investir dans la recherche et l\'exploration pour mieux comprendre le potentiel minier centrafricain.</p>',
                'category' => 0,
                'tags' => [0, 1],
            ],
            [
                'title' => 'Techniques modernes d\'exploitation minière responsable',
                'excerpt' => 'Les nouvelles technologies permettent une exploitation minière plus efficace et respectueuse de l\'environnement. Découvrez les innovations du secteur.',
                'content' => '<h2>L\'évolution de l\'exploitation minière</h2>
                <p>Le secteur minier connaît une transformation majeure grâce à l\'introduction de technologies innovantes qui permettent d\'améliorer l\'efficacité tout en réduisant l\'impact environnemental.</p>
                
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=600&fit=crop" alt="Exploitation minière moderne" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Technologies clés</h3>
                <ul>
                    <li><strong>Automatisation et robotique</strong> : Réduction des risques pour les travailleurs et amélioration de la précision</li>
                    <li><strong>Gestion intelligente des ressources</strong> : Optimisation de l\'utilisation de l\'eau et de l\'énergie</li>
                    <li><strong>Récupération améliorée</strong> : Techniques permettant d\'extraire plus de minerai avec moins de déchets</li>
                    <li><strong>Surveillance en temps réel</strong> : Systèmes de monitoring pour prévenir les incidents environnementaux</li>
                </ul>
                
                <h3>Impact environnemental réduit</h3>
                <p>Ces innovations permettent de minimiser l\'empreinte écologique des opérations minières tout en maintenant la rentabilité. Les nouvelles méthodes de traitement des eaux et de gestion des déchets représentent des avancées significatives.</p>
                
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=600&fit=crop" alt="Mine moderne" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Formation et développement des compétences</h3>
                <p>Le CEGME s\'engage à former les professionnels locaux à ces nouvelles technologies, contribuant ainsi au développement des compétences nationales dans le secteur minier.</p>',
                'category' => 1,
                'tags' => [1, 4],
            ],
            [
                'title' => 'Protection de l\'environnement dans les projets miniers',
                'excerpt' => 'Comment concilier développement minier et protection de l\'environnement ? Le CEGME présente ses approches et solutions durables.',
                'content' => '<h2>Un défi majeur : développement et environnement</h2>
                <p>La conciliation entre développement économique et protection de l\'environnement représente l\'un des défis majeurs du secteur minier moderne. Le CEGME développe des approches innovantes pour répondre à ce défi.</p>
                
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=600&fit=crop" alt="Protection environnementale" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Études d\'impact environnemental</h3>
                <p>Avant tout projet minier, le CEGME réalise des études d\'impact environnemental approfondies qui incluent :</p>
                <ul>
                    <li>Analyse de la biodiversité locale</li>
                    <li>Évaluation des ressources en eau</li>
                    <li>Étude des impacts sur les communautés</li>
                    <li>Planification des mesures de mitigation</li>
                </ul>
                
                <h3>Mesures de protection</h3>
                <p>Plusieurs mesures sont mises en place pour protéger l\'environnement :</p>
                <ul>
                    <li><strong>Gestion des eaux</strong> : Systèmes de traitement et de recyclage</li>
                    <li><strong>Restauration des sites</strong> : Plans de réhabilitation post-exploitation</li>
                    <li><strong>Surveillance continue</strong> : Monitoring environnemental régulier</li>
                    <li><strong>Réduction des émissions</strong> : Technologies propres et efficaces</li>
                </ul>
                
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1200&h=600&fit=crop" alt="Environnement préservé" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Engagement pour le développement durable</h3>
                <p>Le CEGME s\'engage à promouvoir des pratiques minières responsables qui contribuent au développement durable de la République Centrafricaine, en préservant l\'environnement pour les générations futures.</p>',
                'category' => 2,
                'tags' => [2, 3],
            ],
            [
                'title' => 'Innovation technologique dans l\'exploration géologique',
                'excerpt' => 'Les technologies de pointe révolutionnent l\'exploration géologique. Découvrez comment l\'IA, les drones et les capteurs avancés transforment le secteur.',
                'content' => '<h2>La révolution technologique en géologie</h2>
                <p>L\'introduction de technologies de pointe transforme radicalement les méthodes d\'exploration géologique, permettant des découvertes plus rapides et plus précises.</p>
                
                <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a13737?w=1200&h=600&fit=crop" alt="Technologie géologique" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Intelligence artificielle et machine learning</h3>
                <p>L\'IA permet d\'analyser de vastes quantités de données géologiques pour identifier des patterns et prédire la localisation de gisements. Les algorithmes de machine learning améliorent constamment leur précision grâce à l\'apprentissage sur de grandes bases de données.</p>
                
                <h3>Drones et télédétection</h3>
                <ul>
                    <li><strong>Cartographie aérienne haute résolution</strong> : Les drones permettent de cartographier rapidement de vastes zones</li>
                    <li><strong>Capteurs multispectraux</strong> : Détection de minéraux depuis les airs</li>
                    <li><strong>Modèles 3D</strong> : Création de modèles topographiques précis</li>
                </ul>
                
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1200&h=600&fit=crop" alt="Drone géologique" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Capteurs avancés</h3>
                <p>Les nouveaux capteurs permettent de détecter des concentrations minérales à des profondeurs importantes, réduisant ainsi le besoin de forages exploratoires coûteux.</p>
                
                <h3>L\'avenir de l\'exploration</h3>
                <p>Ces innovations ouvrent de nouvelles possibilités pour découvrir et exploiter les ressources minérales de manière plus efficace et responsable.</p>',
                'category' => 3,
                'tags' => [1, 4],
            ],
            [
                'title' => 'Actualités : Nouveau projet minier en Centrafrique',
                'excerpt' => 'Le CEGME annonce le lancement d\'un nouveau projet minier majeur qui devrait créer des emplois et contribuer au développement économique local.',
                'content' => '<h2>Un projet d\'envergure</h2>
                <p>Le CEGME est fier d\'annoncer le lancement d\'un nouveau projet minier d\'envergure en République Centrafricaine. Ce projet représente un investissement significatif et devrait avoir un impact positif sur l\'économie locale.</p>
                
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=600&fit=crop" alt="Projet minier" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Détails du projet</h3>
                <p>Le projet comprend plusieurs phases :</p>
                <ul>
                    <li><strong>Phase 1 - Exploration</strong> : Campagnes d\'exploration approfondies (12-18 mois)</li>
                    <li><strong>Phase 2 - Développement</strong> : Construction des infrastructures (24-36 mois)</li>
                    <li><strong>Phase 3 - Exploitation</strong> : Démarrage des opérations minières</li>
                </ul>
                
                <h3>Bénéfices attendus</h3>
                <ul>
                    <li>Création de plusieurs centaines d\'emplois directs et indirects</li>
                    <li>Formation de la main-d\'œuvre locale</li>
                    <li>Développement des infrastructures locales</li>
                    <li>Contribution aux revenus nationaux</li>
                </ul>
                
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=600&fit=crop" alt="Développement économique" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Engagement environnemental</h3>
                <p>Le projet s\'engage à respecter les normes environnementales les plus strictes et à contribuer au développement durable de la région.</p>',
                'category' => 4,
                'tags' => [0, 2],
            ],
            [
                'title' => 'Formation et développement des compétences dans le secteur minier',
                'excerpt' => 'Le CEGME investit dans la formation des professionnels locaux pour développer les compétences nécessaires au secteur minier centrafricain.',
                'content' => '<h2>Investir dans le capital humain</h2>
                <p>Le développement du secteur minier en République Centrafricaine passe nécessairement par la formation et le développement des compétences locales. Le CEGME s\'engage activement dans cette mission.</p>
                
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=600&fit=crop" alt="Formation professionnelle" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Programmes de formation</h3>
                <p>Le CEGME propose plusieurs programmes de formation adaptés aux besoins du secteur :</p>
                <ul>
                    <li><strong>Formation en géologie</strong> : Techniques d\'exploration et cartographie</li>
                    <li><strong>Formation en exploitation minière</strong> : Méthodes d\'extraction et sécurité</li>
                    <li><strong>Formation HSE</strong> : Hygiène, sécurité et environnement</li>
                    <li><strong>Formation en gestion</strong> : Management de projets miniers</li>
                </ul>
                
                <h3>Partenariats académiques</h3>
                <p>Le CEGME collabore avec des institutions académiques locales et internationales pour offrir des formations de qualité et développer les compétences nécessaires au secteur.</p>
                
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1200&h=600&fit=crop" alt="Éducation" style="width: 100%; max-width: 1200px; height: auto; margin: 20px 0; border-radius: 8px;">
                
                <h3>Impact sur le développement</h3>
                <p>Ces initiatives de formation contribuent non seulement au développement du secteur minier, mais aussi au développement économique général du pays en créant une main-d\'œuvre qualifiée et compétitive.</p>
                
                <h3>Perspectives d\'emploi</h3>
                <p>Les professionnels formés par le CEGME sont bien positionnés pour saisir les opportunités d\'emploi dans le secteur minier en pleine croissance en République Centrafricaine.</p>',
                'category' => 4,
                'tags' => [0, 2],
            ],
        ];

        // Créer les articles
        foreach ($articles as $index => $article) {
            $featuredImage = $this->downloadImage($imageUrls['featured'][$index], "posts/featured-{$index}.jpg");
            $headerImage = $this->downloadImage($imageUrls['header'][$index], "posts/header-{$index}.jpg");

            $post = Post::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'excerpt' => $article['excerpt'],
                'content' => $article['content'],
                'featured_image' => $featuredImage,
                'header_image' => $headerImage,
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => $createdCategories[$article['category']]->id,
                'published_at' => now()->subDays($index * 3),
            ]);

            // Attacher les tags
            $postTags = [];
            foreach ($article['tags'] as $tagIndex) {
                $postTags[] = $createdTags[$tagIndex]->id;
            }
            $post->tags()->sync($postTags);
        }

        $this->command->info('✓ 6 articles créés avec succès');
        $this->command->info('✓ Toutes les données ont été ajoutées avec succès !');
    }

    /**
     * Download an image from URL and store it locally
     */
    private function downloadImage(string $url, string $path): ?string
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                Storage::disk('public')->put($path, $response->body());
                return $path;
            }
        } catch (\Exception $e) {
            $this->command->warn("Échec du téléchargement de l'image depuis {$url}: " . $e->getMessage());
        }

        return null;
    }
}








