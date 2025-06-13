
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

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
session_unset();

/*-------------------------------------------------------*/
// Enregistrement des variables de session
if ($session_name !== null)
    $_SESSION['name'] = $session_name ;

?>

<!DOCTYPE html>
<html lang="fr">

    <head>

        <!--////////////////////////////////////////////////////-->
                    <!--Les metas données-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpportuniSatge</title>

        <!--////////////////////////////////////////////////////-->
                    <!--styles -->
        <link rel="stylesheet" href="assets/css/style.css">

        <!--////////////////////////////////////////////////////-->
                    <!--Icons-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

    <!--////////////////////////////////////////////////////-->
                    <!-- Header de l'invité -->
    <header class="header">
        
        <a href="#" class="logo">OpportuniStage</a>

        <i class='bx  bxs-menu' id="menu-icon" ></i> 

        <nav class="navbar">
            <a href="index.php" >Acceuil</a>
            <a href="#about-header" class="active">À propos</a>
            <a href="contact.php">Contact</a>

            <button type="button" class="login-btn-modal">Se connecter</button>

        </nav>

    </header>


    <!--////////////////////////////////////////////////////-->
                <!--alerts-->
    <?php include './includes/alerts.php' ?>


    <!--////////////////////////////////////////////////////-->
                <!-- Modal de connexion -->
    <?php include './includes/auth_modal.php' ?>


    <!--////////////////////////////////////////////////////-->
                <!-- Opportunistage-->
    <div class="site-name">
        <h1>À propos d’OpportuniStage</h1>
    </div>


    <!--////////////////////////////////////////////////////-->
                <!-- Sections a propos -->
    <section class="about-header" id="about-header">

                <!--Header a propos-->
        <div class="about-header-content">
            <h2>À propos d’OpportuniStage</h2>
            <h3>Un projet académique pour l’insertion des étudiants</h3>
            <p>OpportuniStage est une initiative académique dédiée à favoriser l’insertion professionnelle des étudiants de l’enseignement supérieur. La plateforme permet aux étudiants de découvrir et de postuler à des offres de stage proposées par des entreprises engagées dans la formation des jeunes talents.</p>
            <p>Pensé comme un outil moderne et dynamique, OpportuniStagestrong> facilite les échanges entre étudiants, entreprises et établissements d’enseignement, tout en centralisant les démarches liées aux stages.</p>

            <a href="#about-missions" class="btn-about-content"><i class="fa-regular fa-circle-down"></i></a>
        </div>

    </section>

                <!--Missions a propos-->
    <section class="about-missions" id="about-missions">
        <h2>Nos Missions ?</h2>

        <div class="about-mission-container">

            <div class="about-mission-box">
                <i class="fa-solid fa-share-nodes" style="color:#4FB0E3;"></i> 
                <h3>Matching</h3>
                <p>Mettre en relation les étudiants et les entreprises pour faciliter l’accès à des stages enrichissants et pertinents selon le parcours académique.</p>
            </div>

            <div class="about-mission-box">
                <i class="fa-solid fa-suitcase" style="color:#2ECC71"></i>
                <h3>Visibilité</h3>
                <p>Offrir une vitrine numérique aux entreprises afin qu’elles puissent présenter leurs offres de stages aux étudiants de manière simple et ciblée.</p>
            </div>

            <div class="about-mission-box">
                <i class="fa-solid fa-comment-dots" style="color:#E74C3C"></i>
                <h3>Services</h3>
                <p>Accompagner les utilisateurs dans leurs démarches : publication d’offres, gestion des candidatures, et accès aux informations essentielles du processus.</p>
            </div>

        </div>

    </section>

    <!--////////////////////////////////////////////////////-->
                <!-- footer -->
    <?php include 'includes/footer.php' ?>


    <!--//////////////////////////////////////////////////////////-->
                <!--Partie du scroll reveal-->
    <script src="https://unpkg.com/scrollreveal"></script>


    <!--////////////////////////////////////////////////////-->
                <!--scripts-->
    <script src="./assets/js/script.js"></script>

    </body>

</html>
