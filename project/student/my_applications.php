
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
$session_id = $_SESSION['student-id'] ?? null;

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

    $student_id = $student['student_id'];

    //recuperer les candidatures de l'etudiant
    $query_application = "SELECT applications.*, offers.*, companies.company_name
                          FROM applications
                          JOIN offers ON offers.offer_id = applications.application_offer_id
                          JOIN companies ON companies.company_id = offers.offer_company_id
                          WHERE applications.application_student_id = :student_id
                          ORDER BY applications.application_created_at DESC";
    $result_applications = $PDO -> prepare($query_application);
    $result_applications -> bindParam(":student_id", $student_id, PDO::PARAM_INT);
    $result_applications -> execute();
    $applications = $result_applications -> fetchAll(PDO::FETCH_ASSOC);
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
                    <!--alerts-->
        <?php include '../includes/alerts.php' ?>

        <!--////////////////////////////////////////////////////-->
                    <!-- Header de l'etudiant -->
        <header class="header">

            <a href="#" class="logo">OpportuniStage</a>

            <i class='bx bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="../student/dashboard.php">Tableau de bord</a>
                <a href="../student/offers.php">Offres de stage</a>
                <a href="#" class="active">Mes candidatures</a>
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

        <!--////////////////////////////////////////////////////-->
        <!-- Gerer la correspondance des langues -->
        <?php foreach($applications as $application) : ?>

            <?php
            
                //Formater la date en francais 
                $date = new DateTime($application['application_created_at']);
                $formatter = new IntlDateFormatter(
                    'fr_FR',
                    IntlDateFormatter::LONG,
                    IntlDateFormatter::NONE,
                    'Africa/Kinshasa',
                    IntlDateFormatter::GREGORIAN,
                    'd MMMM yyyy'
                );
                $date_fr = $formatter -> format($date);
            ?>

        <?php endforeach; ?>


        <!--////////////////////////////////////////////////////-->
                    <!-- mes candidatures -->
        <section class="view-offer">

            <h2>Mes candidatures</h2>

            <?php if (count($applications) === 0): ?>

                <div class="no-offer">Aucune candidature pour le moment.</div>

            <?php else: ?>

                <?php foreach ($applications as $application) : ?>

                    <div class="offer-box-companies">

                        <div class="offer-companies-card">
                            <h4><?php echo htmlspecialchars($application['offer_title'] ?? null) ?></h4>
                            <p class="company-name"><?php echo htmlspecialchars($application['company_name'] ?? null) ?></p>
                            <p class="offer-description"><?php echo htmlspecialchars($application['offer_description'] ?? null) ?></p>
                            <p style="margin-top: .6rem;">candidature soumise <span style="font-weight: 600">le <?php echo htmlspecialchars($date_fr ?? null) ?></span></p>
                            <p style="margin-top: .8rem;">
                                <i class="fa-solid fa-location-dot"></i>
                                <?php echo htmlspecialchars($application['offer_location'] ?? null) ?>
                            </p>
                        </div>

                        <!--////////////////////////////////////////////////////-->
                            <!-- status de la candidature -->
                        <?php 
                            foreach($applications as $application){ 
                                $status = $application['application_status'];
                                $class_status = [
                                    'rejected' => 'rejected-status',
                                    'waiting' => 'waiting-status',
                                    'accepted' => 'accepted-status'
                                ];

                                $status_text = [
                                    'rejected' => 'Rejetée',
                                    'waiting' => 'En attente',
                                    'accepted' => 'Acceptée'
                                ];
                            }
                            
                        ?>

                        <div class="offer-card-action">
                            <p class="<?php echo $class_status[$status] ?? 'waiting-status' ?>">
                                <?php echo $status_text[$status] ?? 'En attente' ?>
                            </p>
                            <a href="drop_application.php?id=<?= $application['application_id'] ?>" class="drop-application">Supprimer</a>
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