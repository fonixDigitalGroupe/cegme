<?php

namespace App\Services;

use App\Models\Offre;
use App\Models\FilteringRule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class OfferFilteringService
{
    /**
     * Filtre les offres selon les règles de filtrage actives
     * 
     * @param Collection|array $offres Les offres à filtrer
     * @return Collection Les offres filtrées
     */
    public function filterOffers($offres): Collection
    {
        if (!is_array($offres) && !($offres instanceof Collection)) {
            $offres = collect([$offres]);
        } elseif (is_array($offres)) {
            $offres = collect($offres);
        }

        // Récupérer toutes les règles actives
        try {
            $rules = FilteringRule::with(['countries', 'activityPoles.keywords'])
                ->active()
                ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si la table n'existe pas (migrations non exécutées), ne pas provoquer une 500
            Log::warning('OfferFilteringService: table filtering_rules manquante, retour des offres sans filtrage', ['error' => $e->getMessage()]);
            return $offres;
        } catch (\Exception $e) {
            Log::warning('OfferFilteringService: erreur lors de la récupération des règles de filtrage', ['error' => $e->getMessage()]);
            return $offres;
        }

        if ($rules->isEmpty()) {
            // Si aucune règle active, retourner toutes les offres
            return $offres;
        }

        // Grouper les règles par source pour optimiser
        $rulesBySource = $rules->groupBy('source');

        // Filtrer les offres par source
        $filtered = collect();
        $offresBySource = $offres->groupBy('source');

        foreach ($offresBySource as $source => $sourceOffres) {
            // Si aucune règle pour cette source, accepter toutes les offres de cette source
            if (!$rulesBySource->has($source)) {
                $filtered = $filtered->merge($sourceOffres);
                continue;
            }

            $sourceRules = $rulesBySource->get($source);
            $sourceFiltered = $sourceOffres->filter(function ($offre) use ($sourceRules) {
                // Une offre est valide si elle correspond à AU MOINS UNE règle
                foreach ($sourceRules as $rule) {
                    if ($this->offerMatchesRule($offre, $rule)) {
                        // Enregistrer les pays autorisés pour cette offre (pour l'affichage)
                        if ($rule->countries->isNotEmpty()) {
                            $allowedCountries = $rule->countries->pluck('country')->toArray();
                            $filteredPays = $offre->getFilteredPays($allowedCountries);
                            // Stocker les pays filtrés dans une propriété dynamique
                            $offre->filtered_pays = $filteredPays;
                        } else {
                            // Si aucun filtre de pays, garder tous les pays
                            $offre->filtered_pays = $offre->pays;
                        }
                        return true;
                    }
                }
                return false;
            });

            // Appliquer le filtrage strict : accepter seulement les offres qui correspondent
            $filtered = $filtered->merge($sourceFiltered);
        }

        // Retourner les offres filtrées (peut être vide si aucune offre ne correspond aux critères)
        return $filtered;
    }

    /**
     * Vérifie si une offre correspond à une règle de filtrage
     * LOGIQUE SIMPLIFIÉE ET TRÈS TOLÉRANTE
     * 
     * @param Offre $offre
     * @param FilteringRule $rule
     * @return bool
     */
    private function offerMatchesRule(Offre $offre, FilteringRule $rule): bool
    {
        $hasMarketTypeFilter = !empty($rule->market_type);
        $hasCountryFilter = $rule->countries->isNotEmpty();
        $hasKeywordFilter = $rule->activityPoles->isNotEmpty();
        
        // Si aucun filtre n'est spécifié, accepter toutes les offres
        if (!$hasMarketTypeFilter && !$hasCountryFilter && !$hasKeywordFilter) {
            return true;
        }

        $allMatch = true; // On commence par supposer que tout correspond

        // 1. Vérifier le type de marché (si spécifié)
        if ($hasMarketTypeFilter) {
            if (!$this->matchesMarketType($offre, $rule->market_type)) {
                $allMatch = false;
            }
        }
        
        // 2. Vérifier le pays (si des pays sont spécifiés)
        if ($hasCountryFilter) {
            if (!$this->matchesCountry($offre, $rule->countries->pluck('country')->toArray())) {
                $allMatch = false;
            }
        }

        // 3. Vérifier les mots-clés des pôles d'activité (si des pôles sont spécifiés)
        if ($hasKeywordFilter) {
            $keywordsMatch = false;
            foreach ($rule->activityPoles as $activityPole) {
                $keywords = $activityPole->keywords->pluck('keyword')->toArray();
                if ($this->matchesKeywords($offre, $keywords)) {
                    $keywordsMatch = true;
                    break;
                }
            }
            if (!$keywordsMatch) {
                $allMatch = false;
            }
        }

        // LOGIQUE STRICTE : Accepter seulement si TOUS les critères spécifiés correspondent
        // Si tous les critères correspondent, accepter l'offre
        return $allMatch;
    }

    /**
     * Vérifie si l'offre correspond au type de marché
     * 
     * @param Offre $offre
     * @param string|null $marketType
     * @return bool
     */
    private function matchesMarketType(Offre $offre, ?string $marketType): bool
    {
        // Si aucun type de marché spécifié, retourner true (pas de filtre)
        if (empty($marketType)) {
            return true;
        }
        
        // Extraire le texte à analyser
        $text = strtolower($offre->titre . ' ' . ($offre->acheteur ?? ''));
        
        // Mots-clés pour bureau d'études (prioritaires)
        $bureauEtudeKeywords = [
            'bureau d\'étude',
            'bureau d\'études',
            'bureau de etude',
            'bureau de etudes',
            'cabinet d\'études',
            'cabinet d\'étude',
            'cabinet',
            'consulting',
            'consultance',
            'étude',
            'études',
            'studies',
            'study',
            'consulting services',
            'consultancy services',
            'services de conseil',
            'audit',
            'évaluation',
            'surveillance',
            'monitoring',
            'faisabilité',
        ];

        // Mots-clés pour consultant individuel (prioritaires - patterns spécifiques)
        $consultantIndividuelKeywords = [
            'consultant individuel',
            'individual consultant',
            'expert individuel',
            'individual expert',
            'spécialiste',
            'specialist',
        ];

        // Détection prioritaire pour consultant individuel (plus spécifique)
        if ($marketType === 'consultant_individuel') {
            foreach ($consultantIndividuelKeywords as $keyword) {
                if (stripos($text, $keyword) !== false) {
                    return true;
                }
            }
            // Fallback : chercher "expert" ou "consultant" seul (mais pas "bureau")
            if (stripos($text, 'expert') !== false && stripos($text, 'bureau') === false) {
                return true;
            }
            if (stripos($text, 'consultant') !== false && stripos($text, 'bureau') === false) {
                return true;
            }
            return false;
        } elseif ($marketType === 'bureau_d_etude') {
            // Pour bureau d'études, chercher les patterns spécifiques
            foreach ($bureauEtudeKeywords as $keyword) {
                if (stripos($text, $keyword) !== false) {
                    return true;
                }
            }
            // Si on trouve "bureau" ou "cabinet", c'est probablement un bureau d'études
            if (stripos($text, 'bureau') !== false || stripos($text, 'cabinet') !== false) {
                return true;
            }
            return false;
        }

        return false;
    }

    /**
     * Vérifie si l'offre correspond à un des pays autorisés
     * 
     * @param Offre $offre
     * @param array $allowedCountries
     * @return bool
     */
    private function matchesCountry(Offre $offre, array $allowedCountries): bool
    {
        $offreCountry = $offre->pays ?? '';
        
        if (empty($offreCountry)) {
            // Si l'offre n'a pas de pays, on peut l'accepter ou la rejeter
            // Par défaut, on la rejette si des pays sont requis
            return false;
        }

        // Extraire les pays de l'offre (séparés par des virgules)
        $offreCountries = array_map('trim', explode(',', $offreCountry));
        
        // Utiliser CountryMatcher pour une correspondance tolérante aux fautes d'orthographe
        foreach ($allowedCountries as $allowedCountry) {
            foreach ($offreCountries as $offreCountryItem) {
                if (\App\Services\CountryMatcher::matches($allowedCountry, $offreCountryItem)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Vérifie si au moins un mot-clé est trouvé dans l'offre
     * 
     * @param Offre $offre
     * @param array $keywords
     * @return bool
     */
    private function matchesKeywords(Offre $offre, array $keywords): bool
    {
        if (empty($keywords)) {
            return false;
        }

        // Extraire le texte à analyser (titre, description, acheteur)
        $text = strtolower(
            ($offre->titre ?? '') . ' ' .
            ($offre->acheteur ?? '')
        );

        // Si l'offre a une description, l'ajouter aussi
        // Note: On suppose qu'il pourrait y avoir un champ description dans le futur
        // Pour l'instant, on utilise titre et acheteur

        foreach ($keywords as $keyword) {
            $keywordLower = strtolower(trim($keyword));
            
            // Recherche insensible à la casse
            if (stripos($text, $keywordLower) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Applique le filtrage sur toutes les offres existantes en base
     * Utile pour relancer le filtrage après modification des règles
     * 
     * @return array Statistiques du filtrage
     */
    public function applyFilteringToAllOffers(): array
    {
        $allOffres = Offre::all();
        $filteredOffres = $this->filterOffers($allOffres);
        
        $stats = [
            'total' => $allOffres->count(),
            'filtered' => $filteredOffres->count(),
            'rejected' => $allOffres->count() - $filteredOffres->count(),
        ];

        Log::info('OfferFilteringService: Filtrage appliqué sur toutes les offres', $stats);

        return $stats;
    }
}

