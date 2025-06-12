
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
                <!-- header -->
    <?php include './includes/load_header.php' ?>


    <!--////////////////////////////////////////////////////-->
                <!--alerts-->
    <?php include './includes/alerts.php' ?>


    <!--////////////////////////////////////////////////////-->
                <!-- Modal de connexion -->
    <?php include './includes/auth_modal.php' ?>


    <!--////////////////////////////////////////////////////-->
                <!-- Opportunistage-->
    <div class="site-name">
        <h1>Bienvenu(e) sur OpportuniStage</h1>
    </div>


    <!--////////////////////////////////////////////////////-->
                <!-- Sections d'acceuil -->
     <section class="home-header">

        <div class="home-header-content">
            <h1>Stages en entreprises innovantes</h1>
            <p>Des opportunités à saisir !</p>

            <a href="#home-student" class="btn-home-header-content">En savoir plus <i class="fa-regular fa-circle-down"></i></a>
        </div>

        <div class="home-header-img reveal-top">
            <img src="assets/images/home.png" alt="">
        </div>

     </section>

    <section class="home-student">

        <div class="home-student-img">
            <img src="assets/images/student.png" alt="">
        </div>

        <div class="home-student-content reveal-bottom">
            <h2>Une plateforme simple et efficace pour les étudiants</h2>
            <h3>Trouvez un stage en quelques clics</h3>
            <p>Accédez à de nombreuses offres publiées par nos entreprises partenaires, filtrées selon votre filière ou vos préférences.</p>
            <p>Postulez rapidement aux offres qui vous intéressent et suivez l’avancement de vos candidatures via votre espace personnel.</p>
            <p>Recevez des notifications à chaque nouvelle réponse d’une entreprise ou mise à jour de votre statut.</p>
        </div>

    </section>
    
    <section class="home-company">

        <div class="home-company-content">
            <h2>Une plateforme claire et pratique pour les entreprises</h2>
            <h3>Publiez vos offres et trouvez facilement vos futurs stagiaires</h3>
            <p>Diffusez vos offres de stage en toute autonomie, avec la possibilité de cibler les profils d'étudiants selon leur domaine d'études.</p>
            <p>Consultez et gérez les candidatures depuis votre tableau de bord dédié, avec un suivi simple et efficace des réponses.</p>
            <p>Recevez des notifications en temps réel dès qu’un étudiant postule à une offre ou qu’une action est requise.</p>
            <p>Gagnez du temps dans vos processus de recrutement tout en soutenant les jeunes talents.</p>
        </div>

        <div class="home-company-img reveal-top">
            <img src="assets/images/company.png" alt="">
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