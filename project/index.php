
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
        <title>OpportuniStage</title>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Fichier CSS principal -->
        <link rel="stylesheet" href="assets/css/style.css">

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Librairies d'icônes (Boxicons et Font Awesome) -->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Header de l'invité -->
        <header class="header">
            
            <a href="#" class="logo">OpportuniStage</a>

            <i class='bx  bxs-menu' id="menu-icon" ></i> 

            <nav class="navbar">
                <a href="#home-header" class="active">Acceuil</a>
                <a href="about.php">À propos</a>
                <a href="contact.php">Contact</a>

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
                    <!-- Présentation du nom du site -->
        <div class="site-name">
            <h1>Bienvenue sur OpportuniStage</h1>
        </div>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section principale d’accueil avec image et slogan -->
        <section class="home-header" id="home-header">

            <div class="home-header-content">
                <h1>Stages en entreprises innovantes</h1>
                <p>Des opportunités à saisir !</p>

                <!-- Bouton pour descendre vers la section suivante -->
                <a href="#home-student" class="btn-home-header-content">En savoir plus <i class="fa-regular fa-circle-down"></i></a>
            </div>

            <div class="home-header-img reveal-top">
                <img src="assets/images/home.png" alt="">
            </div>

        </section>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section dédiée aux étudiants -->
        <section class="home-student" id="home-student">

            <div class="home-student-img">
                <img src="assets/images/student-removebg-preview.png" alt="">
            </div>

            <div class="home-student-content reveal-bottom">
                <h2>Une plateforme simple et efficace pour les étudiants</h2>
                <h3>Trouvez un stage en quelques clics</h3>
                <p>Accédez à un large choix d’offres de stages publiées par nos entreprises partenaires, adaptées à vos besoins et ambitions.</p>
                <p>Postulez rapidement aux offres qui vous intéressent et suivez l’avancement de vos candidatures via votre espace personnel.</p>
                <p>Bénéficiez de notifications instantanées pour chaque réponse d’entreprise ou mise à jour de votre statut, afin de ne jamais manquer une opportunité.</p>

            </div>

        </section>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section dédiée aux entreprises -->
        <section class="home-company">

            <div class="home-company-content">
                <h2>Une plateforme claire et pratique pour les entreprises</h2>
                <h3>Publiez vos offres et trouvez facilement vos futurs stagiaires</h3>
                <p>Diffusez vos offres de stage en toute autonomie, avec la possibilité de cibler les profils d'étudiants selon leur domaine d'études.</p>
                <p>Consultez et gérez les candidatures depuis votre tableau de bord dédié, avec un suivi simple et efficace des réponses.</p>
                <p>Accédez à toutes les candidatures reçues et traitez-les directement depuis votre espace.</p>
                <p>Gagnez du temps dans vos processus de recrutement tout en soutenant les jeunes talents.</p>
            </div>

            <div class="home-company-img reveal-top">
                <img src="assets/images/company-removebg-preview.png" alt="">
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
