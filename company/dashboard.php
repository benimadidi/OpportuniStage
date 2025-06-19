
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
$session_id = $_SESSION['user-id'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables de session
session_unset();

/*-------------------------------------------------------*/
// Enregistrement des variables de session
if ($session_name !== null)
    $_SESSION['name'] = $session_name ;
if ($session_id > 0)
    $_SESSION['user-id'] = $session_id;

/*-------------------------------------------------------*/
// Initialiser les infos de l'entreprise a null
$company = null ;

if ($session_id){
    require_once '../config/db-config.php';

    //Récupérer les donnees de l'entreprise 
    $query_company = "SELECT * FROM companies WHERE company_user_id = :user_id";
    $result = $PDO -> prepare($query_company);
    $result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
    $result -> execute();
    $company = $result -> fetch(PDO::FETCH_ASSOC);
}

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
        <link rel="stylesheet" href="../assets/css/style.css">

        <!--////////////////////////////////////////////////////-->
                    <!--Icons-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

        <!--////////////////////////////////////////////////////-->
                    <!-- Header de l'entreprise -->
        <header class="header">

            <a href="#" class="logo">OpportuniStage</a>

            <i class='bx   bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="#" class="active">Tableau de bord</a>
                <a href="my_offers.php">Mes offres</a>
                <a href="offer.php">Publier une offre</a>
            </nav>

            <div class="user-auth">
                
                <?php if(!empty($session_name)) : ?>

                    <div class="profile-box">
                        
                        <div class="avatar-circle"><?= strtoupper($company['company_name'][0])?></div>

                        <div class="dropdown">
                            <a href="profil.php?">
                                <i class='bx  bxs-user'  ></i> 
                                Mon Profil
                            </a>

                            <a href="../company/edit_profil.php">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Mettre a jour le profil
                            </a>

                            <a href="../logout.php">
                                <i class="fas fa-right-from-bracket"></i>
                                Se déconnecter
                            </a>
                        </div>
                        
                    </div>

                <?php endif; ?>

            </div>

        </header>

        <!--////////////////////////////////////////////////////-->
                    <!--alerts-->
        <?php include '../includes/alerts.php' ?>






        <!--////////////////////////////////////////////////////-->
                <!-- footer -->
        <?php include '../includes/footer.php' ?>


        <!--//////////////////////////////////////////////////////////-->
                    <!--Partie du scroll reveal-->
        <script src="https://unpkg.com/scrollreveal"></script>


        <!--////////////////////////////////////////////////////-->
                    <!--scripts-->
        <script src="../assets/js/script.js"></script>

    </body>

</html>
