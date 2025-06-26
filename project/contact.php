
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
            <a href="about.php">À propos</a>
            <a href="#contact" class="active">Contact</a>

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
        <h1>Nous Contacter</h1>
    </div>


    <!--////////////////////////////////////////////////////-->
                <!-- Sections a propos -->
    <section class="contact" id="contact">

        <div class="contact-img">
            <img src="assets/images/contact.png" alt="">
        </div>

        <div class="contact-content">
            <h2>Contactez-nous !</h2>
            <h3>OpportuniStage</h3>

            <div class="contact-container">
                <div class="contact-box">
                    <i class="fa-solid fa-house-chimney"></i>
                    <p>
                        Université Protestante du Congo (UPC)<br>
                        12, Avenue de la Connaissance<br>
                        1000 Kinshasa | RDC
                    </p>
                </div>

                <div class="contact-box">
                    <i class="fa-solid fa-envelope"></i>
                    <p><a href="mailto:opportunistage@gmail.com" title="Contactez l'administrateur">opportunistage@gmail.com</a></p>
                </div>
            
                <div class="contact-box">
                    <i class="fa-solid fa-mobile" style="padding-left: .4rem;"></i>
                    <p><a href="tel:+243977564418">+243 977 564 418</a></p>
                </div>
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