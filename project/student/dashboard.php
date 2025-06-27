
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

/*-------------------------------------------------------*/
// Initialiser les infos de l'etudiant a null
$student = null;

if ($session_id){
    //Récupérer les donnees de l'etudiant 
    $query_student = "SELECT * FROM students WHERE student_user_id = :user_id";
    $result = $PDO -> prepare($query_student);
    $result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
    $result -> execute();
    $student = $result -> fetch(PDO::FETCH_ASSOC);

    // Récupérer le nombre total de candidatures de l'étudiant
    $query_application = "SELECT COUNT(application_id) AS total FROM applications 
                          JOIN offers ON offers.offer_id = applications.application_offer_id
                          WHERE applications.application_student_id = :student_id";
    $count_application = $PDO -> prepare($query_application);
    $count_application -> bindParam(":student_id", $student['student_id'], PDO::PARAM_INT);
    $count_application -> execute();
    $applications = $count_application -> fetch(PDO::FETCH_ASSOC);
    $count_application = $applications['total'];

    // Récupérer les 3 dernières offres publiées
    $query = "SELECT offers.*, companies.company_name
              FROM offers
              JOIN companies ON companies.company_id = offers.offer_company_id
              ORDER BY offers.offer_created_at DESC
              LIMIT 3";
    $result_offers = $PDO->prepare($query);
    $result_offers -> execute();
    $offers = $result_offers -> fetchAll(PDO::FETCH_ASSOC);

    // Compter le nombre total d'offres
    $query_offers = "SELECT COUNT(offer_id) AS total FROM offers ";
    $count_offers = $PDO -> prepare($query_offers);
    $count_offers -> execute();
    $count_offers = $count_offers -> fetch(PDO::FETCH_ASSOC);
    $count_offers = $count_offers['total'];

    // Récupérer la date de la dernière candidature
    $query_last_apps = "SELECT application_created_at FROM applications
                        WHERE application_student_id = :student_id
                        ORDER BY application_created_at DESC
                        LIMIT 1";
    $result_last_apps = $PDO -> prepare($query_last_apps);
    $result_last_apps -> bindParam(":student_id", $student['student_id'], PDO::PARAM_INT);
    $result_last_apps -> execute();
    $last_apps = $result_last_apps -> fetch(PDO::FETCH_ASSOC);

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
                    <!-- Gestion du formatage de la date en français -->         
        <?php
            /*Inclure la fonction du formatage de la date*/
            include '../utils/date_format.php';

            $date_fr = dateFormat($last_apps['application_created_at']);
        ?>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Header avec navigation et profil -->
        <header class="header">

            <a href="#" class="logo">OpportuniStage</a>

            <i class='bx bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="#" class="active">Tableau de bord</a>
                <a href="../student/offers.php">Offres de stage</a>
                <a href="../student/my_applications.php">Mes candidatures</a>
            </nav>

            <div class="user-auth">
                
                <?php if(!empty($session_name)) : ?>
                    <div class="profile-box">
                        
                        <div class="avatar-circle"><?= strtoupper($student['student_name'][0] ?? $session_name[0])?></div>

                        <div class="dropdown">
                            <a href="../student/profil.php">
                                <i class='bx  bxs-user'  ></i> 
                                Mon Profil
                            </a>

                            <a href="../student/edit_profil.php">
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

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section principale du dashboard -->
        <section class="dashboard">
            
            <div class="dashboard-card-header">

                <!-- Bloc Mes Candidatures -->
                <a href="my_applications.php">
                    <div class="dashboard-card-box">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <h4>Mes Candidatures</h4>
                        <p><?php echo $count_application ?? 0; ?></p>
                    </div>
                </a>

                <!-- Bloc Offres disponibles -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h4>Offre<?php if ($count_offers > 1) echo 's' ?? ''; ?> disponible<?php if ($count_offers > 1) echo 's' ?? ''; ?></h4>
                    <p class="last-publication"><?php echo $count_offers ?? 0; ?></p>
                </div>

                <!-- Bloc Dernière candidature -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-bullhorn"></i>
                    <h4>Dernière candidature</h4>
                    <p class="last-publication"><?php if (!empty($last_apps['application_created_at'])) echo 'Le ' ?? ''  ?><?php echo $date_fr ?? 'Aucune candidature'  ?></p>
                </div>

            </div>

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
                                        <h4><?php echo htmlspecialchars($offer['offer_title'] ?? '') ?></h4>
                                        <p class="company-name"><?php echo htmlspecialchars($offer['company_name'] ?? '') ?></p>
                                        <p><?php echo htmlspecialchars($offer['offer_description'] ?? '') ?></p>
                                        <p style="margin-top: .8rem;">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <?php echo htmlspecialchars($offer['offer_location'] ?? null) ?>
                                        </p>
                                    </div>

                                    <div class="offer-card-action">
                                        <a href="offer_details.php?id=<?= $offer['offer_id'] ?>">Postuler</a>
                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

                <div class="dashboard-card-content right">

                    <a href="offers.php">
                        <div class="aside-card-box" >
                            <i class="fa-solid fa-file-signature"></i>
                            <p>Postuler pour une offre</p>
                        </div>
                    </a>

                    <a href="edit_profil.php">
                        <div class="aside-card-box">
                            <i class='bx  bxs-user'  ></i>
                            <p>Mettre à jour le profil</p>
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