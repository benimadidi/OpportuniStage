
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(0);
ini_set('display_errors', 0);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Recuperation des variables de session
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$active_form = $_SESSION['active-form'] ?? '';

/*-------------------------------------------------------*/
// Suppression des variables de session
unset($_SESSION['alerts']);

?>

<!DOCTYPE html>
<html lang="fr">

    <head>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Métadonnées de la page -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpportuniSatge</title>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!--styles -->
        <link rel="stylesheet" href="assets/css/style.css">

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!--Icones-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Header pour les invités non connectés -->
        <header class="header">
            
            <a href="#" class="logo">OpportuniStage</a>

            <!-- Icône du menu burger, visible en version mobile -->
            <i class='bx  bxs-menu' id="menu-icon" ></i> 

            <!-- Barre de navigation -->
            <nav class="navbar">
                <a href="index.php" >Acceuil</a>
                <a href="#about-header" class="active">À propos</a>
                <a href="contact.php">Contact</a>

                <!-- Bouton pour ouvrir la modal de connexion -->
                <button type="button" class="login-btn-modal">Se connecter</button>

            </nav>

        </header>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                     <!-- Inclusion des alertes -->
        <?php include './includes/alerts.php' ?>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Inclusion de la modal d’authentification -->
        <?php include './includes/auth_modal.php' ?>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Titre principal de la page -->
        <div class="site-name">
            <h1>À propos d’OpportuniStage</h1>
        </div>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section d’introduction à propos du projet -->
        <section class="about-header" id="about-header">

                    <!-- Contenu de présentation -->
            <div class="about-header-content">
                <h2>À propos d’OpportuniStage</h2>
                <h3>Un projet académique pour l’insertion des étudiants</h3>
                <p>OpportuniStage est une initiative académique dédiée à favoriser l’insertion professionnelle des étudiants de l’enseignement supérieur. La plateforme permet aux étudiants de découvrir et de postuler à des offres de stage proposées par des entreprises engagées dans la formation des jeunes talents.</p>
                <p>Pensé comme un outil moderne et dynamique, OpportuniStage facilite les échanges entre étudiants, entreprises et établissements d’enseignement, tout en centralisant les démarches liées aux stages.</p>

                <!-- Lien pour descendre à la section suivante -->
                <a href="#about-missions" class="btn-about-content"><i class="fa-regular fa-circle-down"></i></a>
            </div>

        </section>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section présentant les missions principales -->
        <section class="about-missions" id="about-missions">
            <h2>Nos Missions ?</h2>

            <div class="about-mission-container">

                <!-- Mission 1 : Matching -->
                <div class="about-mission-box">
                    <i class="fa-solid fa-share-nodes" style="color:#4FB0E3;"></i> 
                    <h3>Matching</h3>
                    <p>Mettre en relation les étudiants et les entreprises pour faciliter l’accès à des stages enrichissants et pertinents selon le parcours académique.</p>
                </div>

                <!-- Mission 2 : Visibilité -->
                <div class="about-mission-box">
                    <i class="fa-solid fa-suitcase" style="color:#2ECC71"></i>
                    <h3>Visibilité</h3>
                    <p>Offrir une vitrine numérique aux entreprises afin qu’elles puissent présenter leurs offres de stages aux étudiants de manière simple et ciblée.</p>
                </div>

                <!-- Mission 3 : Services -->
                <div class="about-mission-box">
                    <i class="fa-solid fa-comment-dots" style="color:#E74C3C"></i>
                    <h3>Services</h3>
                    <p>Accompagner les utilisateurs dans leurs démarches : publication d’offres, gestion des candidatures, et accès aux informations essentielles du processus.</p>
                </div>

            </div>

        </section>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Inclusion du footer commun -->
        <?php include 'includes/footer.php' ?>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Bibliothèque ScrollReveal pour animations au scroll -->
        <script src="https://unpkg.com/scrollreveal"></script>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Script -->
        <script src="./assets/js/script.js"></script>

    </body>

</html>
