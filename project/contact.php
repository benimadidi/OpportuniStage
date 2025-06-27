
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
                        <!-- Header pour les invités non connectés -->
        <header class="header">
            
            <a href="#" class="logo">OpportuniStage</a>

            <!-- Icône du menu burger, visible en version mobile -->
            <i class='bx  bxs-menu' id="menu-icon" ></i> 

            <!-- Barre de navigation -->
            <nav class="navbar">
                <a href="index.php" >Acceuil</a>
                <a href="about.php">À propos</a>
                <a href="#contact" class="active">Contact</a>

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
            <h1>Nous Contacter</h1>
        </div>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section de contact -->
        <section class="contact" id="contact">

            <div class="contact-img">
                <img src="assets/images/contact.png" alt="">
            </div>

            <!-- Contenu texte et coordonnées -->
            <div class="contact-content">
                <h2>Contactez-nous !</h2>
                <h3>OpportuniStage</h3>

                <div class="contact-container">
                    <!-- Adresse physique -->
                    <div class="contact-box">
                        <i class="fa-solid fa-house-chimney"></i>
                        <p>
                            Université Protestante du Congo (UPC)<br>
                            12, Avenue de la Connaissance<br>
                            1000 Kinshasa | RDC
                        </p>
                    </div>

                    <!-- Email de contact -->
                    <div class="contact-box">
                        <i class="fa-solid fa-envelope"></i>
                        <p><a href="mailto:opportunistage@gmail.com" title="Contactez l'administrateur">opportunistage@gmail.com</a></p>
                    </div>
                
                    <!-- Numéro de téléphone -->
                    <div class="contact-box">
                        <i class="fa-solid fa-mobile" style="padding-left: .4rem;"></i>
                        <p><a href="tel:+243977564418">+243 977 564 418</a></p>
                    </div>
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
