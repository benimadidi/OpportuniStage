# OpportuniStage  
*La passerelle entre les talents et les opportunités*

OpportuniStage est une application web de gestion des stages destinée aux étudiants et aux entreprises.  
Elle facilite la mise en relation entre les jeunes à la recherche d'expérience professionnelle et les entreprises désireuses d’accueillir des stagiaires.

Les étudiants peuvent créer un profil, consulter les offres, postuler et suivre l'état de leurs candidatures.  
Les entreprises peuvent publier des offres, consulter les profils des candidats et gérer les candidatures reçues.  
Un tableau de bord administrateur permet de superviser toute la plateforme.


## Fonctionnalités

### Espace Étudiant
- Création et gestion du profil étudiant (informations personnelles, cursus, CV)
- Consultation des offres de stage publiées
- Postulation en ligne aux offres
- Suivi du statut des candidatures

### Espace Entreprise
- Création et gestion du profil entreprise (secteur, taille, description)
- Publication d’offres de stage (détails, durée, rémunération)
- Consultation des candidatures reçues
- Acceptation ou refus des candidatures

### Tableau de Bord Administrateur
- Gestion des utilisateurs (étudiants et entreprises)
- Supervision des offres de stage
- Modération des contenus
- Statistiques globales

### Autres fonctionnalités
- Authentification sécurisée avec gestion des rôles
- Alertes et notifications
- Interface moderne et responsive



## Installation


Suivez ces étapes pour installer et configurer OpportuniStage sur votre serveur local.


### Prérequis

* **Serveur web** (Apache ou autre.)
* **PHP** >= 8.3.14
* **MySQL**
* **Composer** (optionnel, si vous utilisez des dépendances PHP)

---

### 1. Cloner le projet

Clonez le dépôt dans le dossier de votre serveur local :

git clone https://github.com/criagi-upc/projet-final-benimadidi.git
ou téléchargez l’archive ZIP et extrayez-la.

---

### 2. Configuration de la base de données

Importez le schéma fourni (database.sql ou le script généré) :

    ```sql

    SOURCE /chemin/vers/votre/opportunistage.sql;

Vérifiez que toutes les tables ont bien été créées (users, students, companies, offers, applications).

---

### 3. Configuration de l’application

Ouvrez le fichier `config/db-config.php`.

Renseignez vos identifiants de connexion MySQL :

    ```php

    $DB_DSN = 'mysql:host=localhost;dbname=OpportuniStage';
    $DB_USER = 'root';
    $DB_PASS = '';

Adaptez selon votre environnement.

---

### 4. Lancer l’application

Démarrez votre serveur local (Apache ou autre).

Accédez à l’URL correspondante, par exemple :

    ```bash

    http://localhost/opportunistage/project/index.php

L’application est maintenant prête à être utilisée.

---

### 5. Activer le mode développement (Optionnel)

Pour activer l’affichage des erreurs, vérifiez que dans vos scripts PHP vous avez :

    ```php

    error_reporting(-1);
    ini_set('display_errors', 1);

Pensez à désactiver l’affichage des erreurs en production.

---

### Technologies utilisées

Le projet *OpportuniStage* a été développé avec les technologies suivantes :

- **HTML5** – Structure des pages web
- **CSS3** – Mise en forme et responsive design
- **JavaScript** – Interactivité côté client
- **PHP** – Logique métier côté serveur
- **MySQL** – Base de données relationnelle
- **SQL** – Requêtes et gestion des données
- **PDO** – Connexion sécurisée à la base de données
- **Font Awesome / Boxicons** – Icônes et pictogrammes
- **ScrollReveal.js** – Animation lors du défilement des pages

Ces technologies assurent la fiabilité, la sécurité et une expérience utilisateur moderne.



## Structure du projet

Voici l'organisation des fichiers et dossiers principaux du projet OpportuniStage :

    ```bash

    OpportuniStage/
    │
    ├── docs/                                   # Documentation et ressources de conception
    │ ├── maquettes/                            # Maquettes graphiques de l'application
    │ │ └── admin-dashboard.png                 # Exemple de maquette de l'interface admin
    │ ├── Cahier_des_charges.docx               # Cahier des charges du projet
    │ └── Feuille de route pour le projet.docx  # Planification et feuille de route
    │
    ├── project/                                # Code source principal
    │
    │ ├── admin/                                # Pages dédiées à l'administrateur
    │ │ ├── dashboard.php                       # Tableau de bord admin (gestion globale)
    │ │ ├── drop_user.php                       # Suppression d'un compte utilisateur
    │ │ ├── offers_details.php                  # Détails d'une offre vue par l'admin
    │ │ ├── offers.php                          # Liste de toutes les offres publiées
    │ │ ├── profil.php                          # Profil de l'administrateur
    │ │ └── view_user.php                       # Visualisation du profil d'un utilisateur
    │ │
    │ ├── assets/                               # Ressources statiques (CSS, JS, images)
    │ │ ├── css/
    │ │ │ └── style.css                         # Feuille de style principale
    │ │ ├── images/                             # Images utilisées sur le site
    │ │ │ ├── company.png                    
    │ │ │ ├── contac.png                   
    │ │ │ ├── home.png                      
    │ │ │ └── student.png                      
    │ │ └── js/
    │ │   └── script.js                         # Script JavaScript principal
    │ │
    │ ├── company/                              # Pages dédiées aux entreprises
    │ │ ├── applications_received.php           # Candidatures reçues
    │ │ ├── dashboard.php                       # Tableau de bord entreprise
    │ │ ├── drop_offer.php                      # Suppression d'une offre
    │ │ ├── edit_profil.php                     # Édition du profil entreprise
    │ │ ├── my_offers.php                       # Mes offres publiées
    │ │ ├── offer_details.php                   # Détails d'une offre spécifique
    │ │ ├── offer.php                           # Publication d'une nouvelle offre
    │ │ └── profil.php                          # Profil de l'entreprise
    │ │
    │ ├── config/
    │ │ └── db-config.php                       # Configuration de connexion à la base de données
    │ │
    │ ├── controllers/                          # Scripts de traitement des formulaires et actions
    │ │ ├── applications_process.php            # Traitement des candidatures
    │ │ ├── auth_process.php                    # Connexion et inscription
    │ │ ├── drop_offer_process.php              # Suppression d'offre
    │ │ ├── edit_profil_process_2.php           # Autre script de modification de profil
    │ │ ├── edit_profil_process.php             # Modification de profil
    │ │ ├── my_offers_process.php               # Gestion des offres de l'entreprise
    │ │ ├── offer_details_process.php           # Traitement des détails d'une offre
    │ │ └── offer_process.php                   # Création d'une nouvelle offre
    │ │
    │ ├── database/
    │ │ └── OpportuniStage.sql                  # Script SQL de création de la base de données
    │ │
    │ ├── includes/                             # Fichiers inclus dans plusieurs pages
    │ │ ├── alerts.php                          # Affichage des messages d'alerte
    │ │ ├── auth_modal.php                      # Modale de connexion/inscription
    │ │ ├── edit_profil_2.php                   # Bloc d'édition de profil complémentaire
    │ │ └── footer.php                          # Pied de page
    │ │
    │ ├── student/                              # Pages dédiées aux étudiants
    │ │ ├── dashboard.php                       # Tableau de bord étudiant
    │ │ ├── drop_application.php                # Suppression d'une candidature
    │ │ ├── edit_profil.php                     # Modification du profil étudiant
    │ │ ├── my_applications.php                 # Mes candidatures
    │ │ ├── offer_details.php                   # Détail d'une offre
    │ │ ├── offers.php                          # Liste des offres
    │ │ └── profil.php                          # Profil étudiant
    │ │
    │ ├── test/                                 # Répertoires de test 
    │ │ ├── page_de_connexion/                  # Prototype de page de connexion
    │ │ │ ├── auth_process.php
    │ │ │ ├── background.jpg
    │ │ │ ├── db-config.php
    │ │ │ ├── index.php
    │ │ │ ├── logout.php
    │ │ │ ├── script.js
    │ │ │ └── style.css
    │ │ └── test_php_mailer/                    # Test d'envoi d'email avec PHPMailer
    │ │ │ ├── css/
    │ │ │ │ └── style.css
    │ │ │ ├── PHPMailer-Master/                 # Librairie PHPMailer
    │ │ │ │ └── ...
    │ │ │ ├── index.php
    │ │ │ └── SendMailFunction.php
    │ │
    │ ├── uploads/cvs/                          # Dossier de stockage des CV soumis
    │ │ └── ...
    │ │
    │ ├── utils/                                # Fonctions utilitaires
    │ │ ├── PHPMailer-master/                   # Librairie PHPMailer
    │ │ │ └── ...
    │ │ ├── date_format.php                     # Formatage de dates
    │ │ └── send_email.php                      # Fonction d'envoi d'email
    │ │
    │ ├── about.php                             # Page "À propos"
    │ ├── contact.php                           # Page de contact
    │ ├── index.php                             # Page d'accueil 
    │ ├── logout.php                            # Déconnexion
    │
    └── README.md                               # Documentation du projet
    
Cette organisation permet de séparer clairement les responsabilités et facilite la maintenance du projet.



## Guide d’utilisation

Cette section explique comment utiliser l’application une fois installée et configurée.

### Connexion et inscription

- Ouvrir la page d’accueil (`index.php`)
- Créer un compte étudiant ou entreprise
- Se connecter avec votre email et mot de passe

### Pour les entreprises

- Accéder au tableau de bord
- Publier une offre de stage
- Modifier ou supprimer vos offres publiées
- Consulter les candidatures reçues
- Accepter ou refuser une candidature
- Modifier votre profil entreprise

### Pour les étudiants

- Rechercher et consulter les offres disponibles
- Postuler aux offres de votre choix
- Suivre l’état de vos candidatures
- Mettre à jour votre profil étudiant
- Télécharger ou modifier votre CV

### Pour l’administrateur

- Se connecter en tant qu’administrateur
- Gérer les utilisateurs (entreprises et étudiants)
- Supprimer les offres inappropriées
- Superviser l’activité de la plateforme

### Déconnexion

- Cliquer sur le bouton “Se déconnecter” pour fermer votre session en toute sécurité.


---

## 8. Auteur

Ce projet a été conçu et développé par :

- **Toussaint Madidi**
-  Email : benimadidi100@gmail.com
-  Téléphone : +243 977 564 418

N’hésitez pas à me contacter pour toute question ou suggestion.
