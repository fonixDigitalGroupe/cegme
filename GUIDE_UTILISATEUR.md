# Guide d'Utilisation Complet - Plateforme CEGME

Bienvenue dans le guide d'utilisation de la plateforme **CEGME** (Cabinet d'Expertise en Géosciences, Mines et Environnement). Ce document vous aidera à naviguer sur le site et à gérer les contenus via l'interface d'administration.

---

## 1. Présentation de la Plateforme
CEGME est une plateforme dédiée à l'expertise technique dans les domaines des mines, de l'environnement et de la géologie. Elle intègre un système robuste de veille sur les **appels d'offres** internationaux et une section **blog/actualités**.

### Architecture Technique
- **Framework** : Laravel 12 (PHP 8.2+)
- **Base de données** : MySQL / MariaDB
- **Moteur de Recherche** : Filtrage intelligent par mots-clés
- **Scraping** : Spatie Browsershot (headless Chrome)

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

![Aperçu des Offres](/public/manuel/offres%202.png)

### Recherche d'Appels d'offres
Vous pouvez consulter les dernières offres provenant de sources majeures (Banque Mondiale, BAD, AFD, etc.). Les offres sont filtrées pour ne montrer que celles pertinentes pour vos secteurs d'activité.

---

## 3. Guide de l'Espace Administration
*L'accès se fait via le bouton "Se connecter" avec un compte Admin ou Éditeur.*

![Formulaire de Connexion](/public/manuel/CAPTURE%20FORMULAIRE%20CONNEC+XION.png)

### Gestion du Contenu (CMS)
- **Articles (Posts)** : Créez, modifiez ou supprimez des articles de blog.
- **Éditeur** : Utilisez l'interface pour mettre en forme vos articles.

![Gestion des Articles](/public/manuel/ARTICLE1.png)
![Formulaire Article](/public/manuel/Formulaire%20A1.png)

### Gestion des Appels d'offres (Scraping)
C'est le cœur technique de la plateforme. 

#### A. Configuration des Pôles d'activité
Définissez vos domaines d'expertise (ex: Environnement, Mines).
![Gestion des pôles](/public/manuel/Gestion%20des%20poles.png)
![Ajout d'un pôle](/public/manuel/Ajouter%20des%20poles.paint)

#### B. Règles de filtrage
Configurez les sources à surveiller et les pays autorisés. Le système utilise ces règles pour trier les offres récupérées.
![Règles de filtrage](/public/manuel/REGLE%20DE%20FILTRAGE.png)

#### C. Lancement du Scraping
1. Allez dans `Admin > Paramètres de Scraping`.
2. Cliquez sur **Lancer le scraping** pour mettre à jour la liste des offres.
![Paramètres de Scraping](/public/manuel/PARAMETRE%20DE%20SCRAPING.png)

#### D. Paramètres du Système
Configurez les clés API et les réglages globaux dans les paramètres.
![Paramètre 1](/public/manuel/Parametre1.png)
![Paramètre 2](/public/manuel/Paramztre2.png)

### Gestion des Utilisateurs (Admin uniquement)
Permet de créer des comptes pour d'autres membres de l'équipe et de leur attribuer des rôles.
![Gestion Utilisateurs](/public/manuel/Gestion%20USER.png)
![Création Utilisateur](/public/manuel/USER%20Cread.png)

---

## 4. Fonctionnalités Avancées
- **Authentification Google** : Connexion simplifiée via Socialite.
- **Filtrage Intelligent** : Analyse sémantique des offres pour détecter les correspondances avec les mots-clés des pôles d'activité.

---

## 5. Maintenance et Support
Pour toute question technique, contactez l'administrateur système.
