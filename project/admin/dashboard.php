
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(0);
ini_set('display_errors', 0);

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

//Si l'utilisateur est connecté
if ($session_id){
    /*-------------------------------------------------------*/
    //Recuperer le nom de l'admin
    $query_admin = "SELECT user_name FROM users WHERE user_id = :user_id";
    $result = $PDO -> prepare($query_admin);
    $result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
    $result -> execute();
    $admin = $result -> fetch(PDO::FETCH_ASSOC);

    //Recuperer le nombre d'etudiant 
    $query_student = "SELECT COUNT(student_id) AS total FROM students";
    $count_student = $PDO -> prepare($query_student);
    $count_student -> execute();
    $count_student = $count_student -> fetch(PDO::FETCH_ASSOC);
    $count_student = $count_student['total']; 

    //Recuperer le nombre d'entreprise
    $query_company = "SELECT COUNT(company_id) AS total FROM companies";
    $count_company = $PDO -> prepare($query_company);
    $count_company -> execute();
    $count_company = $count_company -> fetch(PDO::FETCH_ASSOC);
    $count_company = $count_company['total'];

    //Recuperer le nombre d'offre
    $query_offer = "SELECT COUNT(offer_id) AS total FROM offers";
    $count_offer = $PDO -> prepare($query_offer);
    $count_offer -> execute();
    $count_offer = $count_offer -> fetch(PDO::FETCH_ASSOC);
    $count_offer = $count_offer['total'];

    //Recuperer le nombre de candidature
    $query_application = "SELECT COUNT(application_id) AS total FROM applications";
    $count_application = $PDO -> prepare($query_application);
    $count_application -> execute();
    $count_application = $count_application -> fetch(PDO::FETCH_ASSOC);
    $count_application = $count_application['total'];

    //Recuperer le 3 dernieres offres
    $query = "SELECT offers.*, companies.company_name
              FROM offers
              JOIN companies ON companies.company_id = offers.offer_company_id
              ORDER BY offers.offer_created_at DESC
              LIMIT 3";
    $result_offers = $PDO->prepare($query);
    $result_offers -> execute();
    $offers = $result_offers -> fetchAll(PDO::FETCH_ASSOC);

    //compter le nombre d'offres
    $query_offers = "SELECT COUNT(offer_id) AS total FROM offers ";
    $count_offers = $PDO -> prepare($query_offers);
    $count_offers -> execute();
    $count_offers = $count_offers -> fetch(PDO::FETCH_ASSOC);
    $count_offers = $count_offers['total'];

    //Compter le nombre de candidature
    $query_application = "SELECT COUNT(application_id) AS total FROM applications";
    $count_application = $PDO -> prepare($query_application);
    $count_application -> execute();
    $count_application = $count_application -> fetch(PDO::FETCH_ASSOC);
    $count_application = $count_application['total'];

}

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
        <link rel="stylesheet" href="../assets/css/style.css">

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!--Icones-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Inclusion des alertes -->
        <?php include '../includes/alerts.php' ?>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Header avec navigation et profil -->
        <header class="header">

            <a href="#" class="logo">OpportuniSatge</a>

            <i class='bx bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="#" class="active">Tableau de bord</a>
                <a href="view_user.php">Utilisateurs</a>
                <a href="offers.php">Offres</a>
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


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section tableau de bord -->           
        <section class="dashboard">

            <!-- Carte des utilisateurs inscrits -->
            <div class="dashboard-card-header admin">

                <!-- Carte des Etudiants inscrits -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h4>Etudiant<?php if ($count_student > 1) echo 's' ?? ''; ?> inscrit<?php if ($count_student > 1) echo 's' ?? ''; ?></h4>
                    <p><?php echo $count_student; ?></p>
                </div>

                <!-- Carte des Entreprises inscrits -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-briefcase"></i>
                    <h4>Entreprise<?php if ($count_company > 1) echo 's' ?? ''; ?> inscrit<?php if ($count_company > 1) echo 's' ?? ''; ?></h4>
                    <p><?php echo $count_company ?? 0; ?></p>
                </div>

                <!-- Carte des Candidatures soumises -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-check-to-slot"></i>
                    <h4>Candidature<?php if ($count_application > 1) echo 's' ?? ''; ?> soumise<?php if ($count_application > 1) echo 's' ?? ''; ?></h4>
                    <p><?php echo $count_application ?? 0; ?></p>
                </div>

                <!-- Carte des Offres publiées -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-file-contract"></i>
                    <h4>Offre<?php if ($count_offers > 1) echo 's' ?? ''; ?> publiée<?php if ($count_offers > 1) echo 's' ?? ''; ?></h4>
                    <p><?php echo $count_offers ?? 0; ?></p>
                </div>

            </div>

            <!-- Partie contenu principal -->
            <div class="dashboard-card-container">

                <div class="dashboard-card-content left">

                    <h2>Dernière<?php if ($count_offers > 1) echo 's' ?? ''; ?> offre<?php if ($count_offers > 1) echo 's' ?? ''; ?> publiée<?php if ($count_offers > 1) echo 's' ?? ''; ?></h2>

                    <?php if ($count_offers === 0): ?>

                        <div class="no-offer">Aucune offre publiée pour le moment.</div>

                    <?php else: ?>

                        <?php foreach($offers as $offer) : ?>

                            <div class="student-dashboard-card">

                                <div class="student-dashboard-card-box">

                                    <div class="student-dashboard-card-layer">
                                        <!-- Titre de l'offre -->
                                        <h4><?php echo htmlspecialchars($offer['offer_title'] ?? '') ?></h4>

                                        <!-- Nom de l'entreprise -->
                                        <p class="company-name"><?php echo htmlspecialchars($offer['company_name'] ?? '') ?></p>

                                        <!-- Description de l'offre -->
                                        <p><?php echo htmlspecialchars($offer['offer_description'] ?? '') ?></p>

                                        <!-- Localisation de l'offre -->
                                        <p style="margin-top: .8rem;">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <?php echo htmlspecialchars($offer['offer_location'] ?? null) ?>
                                        </p>
                                    </div>

                                    <!-- Bouton Details -->
                                    <div class="offer-card-action">
                                        <a href="offer_details.php?id=<?= $offer['offer_id'] ?>">Details</a>
                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

                <div class="dashboard-card-content right">
                    
                    <!-- Gérer les utilisateurs -->
                    <a href="view_user.php">
                        <div class="aside-card-box" >
                            <i class='bx  bxs-user'  ></i>
                            <p>Gérer les utilisateurs</p>
                        </div>
                    </a>

                    <!-- Gérer les offres -->
                    <a href="offers.php">
                        <div class="aside-card-box">
                            <i class="fa-solid fa-book"></i>
                            <p>Gérer les offres</p>
                        </div>
                    </a>

                </div>

            </div>

        </section>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Inclusion du footer commun -->
        <?php include '../includes/footer.php' ?>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Bibliothèque ScrollReveal pour animations au scroll -->
        <script src="https://unpkg.com/scrollreveal"></script>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Script -->
        <script src="../assets/js/script.js"></script>

    </body>

</html>
