
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
$session_id = $_SESSION['student-id'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Initialisation de la variable student
$student = null;

if ($session_id){
    // Récupérer les informations de l'étudiant connecté
    $query_student = "SELECT * FROM students WHERE student_user_id = :user_id";
    $result = $PDO -> prepare($query_student);
    $result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
    $result -> execute();
    $student = $result -> fetch(PDO::FETCH_ASSOC);

    // Récupérer toutes les offres publiées par toutes les entreprises
    $query = "SELECT offers.*, companies.company_name
              FROM offers
              JOIN companies ON companies.company_id = offers.offer_company_id
              ORDER BY offers.offer_created_at DESC";
    $result_offers = $PDO->prepare($query);
    $result_offers -> execute();
    $offers = $result_offers -> fetchAll(PDO::FETCH_ASSOC);

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

            <a href="#" class="logo">OpportuniStage</a>

            <i class='bx bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="../student/dashboard.php">Tableau de bord</a>
                <a href="#" class="active">Offres de stage</a>
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
                    <!-- Section principale : affichage des offres -->>
        
        <section class="view-offer">

            <h2>Offres de stage</h2>

            <?php if (count($offers) === 0): ?>

                <div class="no-offer">Aucune offre publiée pour le moment.</div>

            <?php else: ?>

                <!-- Boucle sur les offres -->
                <?php foreach ($offers as $offer) : ?>

                    <div class="offer-box-companies">

                        <div class="offer-companies-card">
                            <!-- Titre de l'offre -->
                            <h4><?php echo htmlspecialchars($offer['offer_title'] ?? '') ?></h4>

                            <!-- Nom de l'entreprise -->
                            <p class="company-name"><?php echo htmlspecialchars($offer['company_name'] ?? '') ?></p>

                            <!-- Description de l'offre -->
                            <p><?php echo htmlspecialchars($offer['offer_description'] ?? '') ?></p>

                            <!-- Localisation -->
                            <p style="margin-top: .8rem;">
                                <i class="fa-solid fa-location-dot"></i>
                                <?php echo htmlspecialchars($offer['offer_location'] ?? null) ?>
                            </p>
                        </div>

                        <!-- Bouton Postuler -->
                        <div class="offer-card-action">
                            <a href="offer_details.php?id=<?= $offer['offer_id'] ?>">Postuler</a>
                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

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
