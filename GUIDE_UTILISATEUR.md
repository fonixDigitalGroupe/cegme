# Guide d'Utilisation Complet - Plateforme CEGME

Bienvenue dans le guide d'utilisation de la plateforme **CEGME** (Cabinet d'Expertise en Géosciences, Mines et Environnement). Ce document vous aidera à naviguer sur le site et à gérer les contenus via l'interface d'administration.

---

## 1. Présentation de la Plateforme
CEGME est une plateforme dédiée à l'expertise technique dans les domaines des mines, de l'environnement et de la géologie. Elle intègre un système robuste de veille sur les **appels d'offres** internationaux et une section **blog/actualités**.

---

## 2. Guide du Site Public

### Navigation Principale
- **Accueil** : Présentation générale de l'entreprise et de ses pôles d'expertise.
- **À Propos** : Histoire, mission et équipe du cabinet CEGME.
- **Services** : Détail des prestations proposées (Études d'impact, Exploration minière, etc.).
- **Réalisations** : Galerie des projets et contrats déjà réalisés.
- **Actualités / Blog** : Articles de fond sur le secteur et actualités de l'entreprise.
- **Appels d'offres** : Liste des opportunités d'affaires scrapées et filtrées automatiquement.
- **Contact** : Formulaire pour solliciter les services du cabinet.

### Recherche d'Appels d'offres
Vous pouvez consulter les dernières offres provenant de sources majeures (Banque Mondiale, BAD, AFD, etc.). Les offres sont filtrées pour ne montrer que celles pertinentes pour vos secteurs d'activité.

---

## 3. Guide de l'Espace Administration
*L'accès se fait via le bouton "Se connecter" avec un compte Admin ou Éditeur.*

### Gestion du Contenu (CMS)
- **Articles (Posts)** : Créez, modifiez ou supprimez des articles de blog. Vous pouvez utiliser l'éditeur visuel pour mettre en forme vos textes et uploader des images.
- **Catégories & Tags** : Organisez vos articles pour faciliter la navigation des utilisateurs.

### Gestion des Appels d'offres (Scraping)
C'est le cœur technique de la plateforme. 
1. **Pôles d'activité** : Définissez vos domaines d'expertise (ex: Environnement, Mines). Associez des **mots-clés** à chaque pôle pour que le système sache quelles offres vous intéressent.
2. **Règles de filtrage** : Configurez les sources à surveiller et les pays autorisés.
3. **Lancement du Scraping** :
    - Allez dans `Admin > Scraping`.
    - Cliquez sur **Lancer le scraping** pour mettre à jour la liste des offres en temps réel.
    - Le système passera en revue les sources (World Bank, AfDB, etc.) et ne conservera que les offres correspondant à vos mots-clés et pays.
4. **Scraping Programmé** : Le système est configuré pour s'exécuter automatiquement à intervalles réguliers pour garantir que vous ne manquiez aucune opportunité.

### Gestion des Utilisateurs (Admin uniquement)
Permet de créer des comptes pour d'autres membres de l'équipe et de leur attribuer des rôles (Admin ou Éditeur).

---

## 4. Fonctionnalités Spéciales
- **Authentification Google** : Connectez-vous rapidement en utilisant votre compte professionnel Google.
- **Filtrage Intelligent** : Les offres sont analysées automatiquement dès leur récupération pour détecter les pays et les domaines d'activité, même si l'orthographe varie légèrement (grâce à notre moteur de correspondance).

---

## 5. Support Technique
Pour toute question technique ou demande de modification majeure, veuillez contacter l'administrateur système ou l'équipe de développement.
