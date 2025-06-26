
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Inclure le fichier de configuration
require_once '../config/db-config.php';

/*-------------------------------------------------------*/
// Recuperation des variables de session
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$session_id = $_SESSION['user-id'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
//Recuperer le nom de l'admin
$query_admin = "SELECT user_name FROM users WHERE user_id = :user_id";
$result = $PDO -> prepare($query_admin);
$result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
$result -> execute();
$admin = $result -> fetch(PDO::FETCH_ASSOC);

/*-------------------------------------------------------*/
//Recuperer les offres de toutes les entrepries
$query = "SELECT offers.*, companies.company_name
            FROM offers
            JOIN companies ON companies.company_id = offers.offer_company_id
            ORDER BY offers.offer_created_at DESC";
$result_offers = $PDO->prepare($query);
$result_offers -> execute();
$offers = $result_offers -> fetchAll(PDO::FETCH_ASSOC);

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
                    <!--alerts-->
        <?php include '../includes/alerts.php' ?>


        <!--////////////////////////////////////////////////////-->
                    <!-- Header de l'admin -->
        <header class="header">

            <a href="#" class="logo">OpportuniSatge</a>

            <i class='bx bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="dashboard.php" >Tableau de bord</a>
                <a href="view_user.php">Utilisateurs</a>
                <a href=" #" class="active">Offres</a>
            </nav>

            <div class="user-auth">
                
                <?php if(!empty($session_name)) : ?>
                    <div class="profile-box">
                        
                        <div class="avatar-circle"><?php echo strtoupper($admin['user_name'][0])?></div>

                        <div class="dropdown">
                            <a href="../includes/edit_profil_2.php">
                                <i class="fa-solid fa-pen-to-square"></i> 
                                Modifier le profil
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
                    <!-- offres de toutes les entreprises -->
        
        <section class="view-offer">

            <h2>Offres de stage</h2>

            <?php if (count($offers) === 0): ?>

                <div class="no-offer">Aucune offre publiée pour le moment.</div>

            <?php else: ?>

                <?php foreach ($offers as $offer) : ?>

                    <div class="offer-box-companies">

                        <div class="offer-companies-card">
                            <h4><?php echo htmlspecialchars($offer['offer_title'] ?? '') ?></h4>
                            <p class="company-name"><?php echo htmlspecialchars($offer['company_name'] ?? '') ?></p>
                            <p><?php echo htmlspecialchars($offer['offer_description'] ?? '') ?></p>
                            <p style="margin-top: .8rem;">
                                <i class="fa-solid fa-location-dot"></i>
                                <?php echo htmlspecialchars($offer['offer_location'] ?? null) ?>
                            </p>
                        </div>

                        <div class="offer-card-action">
                            <a href="offer_details.php?id=<?= $offer['offer_id'] ?>">Détails</a>
                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>


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