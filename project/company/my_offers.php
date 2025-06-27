
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
$session_id = $_SESSION['user-id'] ?? null;

$offers = $_SESSION['offers'] ?? [];

/*-------------------------------------------------------*/
/*Recuperation des offres de l'utilisateur*/
require_once '../controllers/my_offers_process.php';

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Initialisation de la variable de l'entreprise
$company = null ;

if ($session_id){
    require_once '../config/db-config.php';

    // Récupérer les informations de l'entreprise correspondante à l'utilisateur
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

            <i class='bx   bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="dashboard.php">Tableau de bord</a>
                <a href="#" class="active">Mes offres</a>
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


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section d'affichage des offres -->
        <section class="view-offer">

            <h2>Mes offres</h2>

            <?php if (count($offers) === 0): ?>

                <div class="no-offer">Aucune offre publiée pour le moment.</div>

            <?php else: ?>

                <!-- Affichage des offres -->
                <div class="offer-box">

                    <?php foreach ($offers as $offer) : ?>

                        <div class="offer-card">

                            <!-- Titre de l'offre -->
                            <div class="offer-card-header">
                                <h6><?php echo htmlspecialchars(ucfirst($offer['offer_title'])); ?></h6>
                                <div class="offer-status">Publiée</div>
                            </div>

                            <!-- Description de l'offre -->
                            <p><?php echo htmlspecialchars(ucfirst($offer['offer_description'])); ?></p>

                            <!-- Actions de l'offre -->
                            <div class="offer-card-action">
                                <!-- Lien pour voir l'offre -->
                                <a href="offer_details.php?id=<?php echo $offer['offer_id']; ?>" class="offer-details">Voir l'offre</a>

                                <!-- Lien pour supprimer l'offre -->
                                <a href="drop_offer.php?id=<?php echo $offer['offer_id']; ?>" class="offer-delete">Supprimer</a>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>
        

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Boîte de confirmation de suppression -->
        <div id="confirm-modal" class="modal-overlay">

            <div class="modal-content">

                <h4>Confirmer l'action</h4>

                <p>Êtes-vous sûr de vouloir supprimer cette offre ?</p>

                <div class="modal-buttons">
                    <button id="confirm-yes" class="reject">Oui, supprimer</button>
                    <button id="confirm-no" class="cancel">Annuler</button>
                </div>
                
            </div>

        </div>


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