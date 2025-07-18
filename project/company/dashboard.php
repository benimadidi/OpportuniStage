
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
/* Initialisation des variables */
$company = null ;
$offers = [];
$last_publication = null;

/* Si l'utilisateur est connecté */
if ($session_id){

    /* Récupérer les infos de l'entreprise */ 
    $query_company = "SELECT * FROM companies WHERE company_user_id = :user_id";
    $result = $PDO -> prepare($query_company);
    $result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
    $result -> execute();
    $company = $result -> fetch(PDO::FETCH_ASSOC);

    /* Récupérer la date de la dernière publication */
    $query_last_publication = "SELECT offer_created_at FROM offers 
                               WHERE offer_company_id = :company_id 
                               ORDER BY offer_id DESC LIMIT 1";
    $result_last_publication = $PDO -> prepare($query_last_publication);
    $result_last_publication -> bindParam(":company_id", $company['company_id'], PDO::PARAM_INT);
    $result_last_publication -> execute();
    $last_publication = $result_last_publication -> fetch(PDO::FETCH_ASSOC);
}

/* Si l'entreprise existe */
if ($company){
    $company_id = $company['company_id'];

    /* Les 3 dernières offres */
    $query = "SELECT * FROM offers 
              WHERE offer_company_id = :company_id 
              ORDER BY offer_id DESC 
              LIMIT 3"; 

    $result = $PDO -> prepare($query);
    $result -> bindParam(":company_id", $company_id, PDO::PARAM_INT);
    $result -> execute();
    $offers = $result -> fetchAll(PDO::FETCH_ASSOC);

    /* Compter toutes les offres */
    $query_all_offers = "SELECT COUNT(offer_id) AS total FROM offers WHERE offer_company_id = :company_id";
    $result_all_offers = $PDO -> prepare($query_all_offers);
    $result_all_offers -> bindParam(":company_id", $company_id, PDO::PARAM_INT);
    $result_all_offers -> execute();
    $all_offers = $result_all_offers -> fetch(PDO::FETCH_ASSOC);
    $total_offers = $all_offers['total'] ?? 0;

    /* Compter le nombre de candidatures en attente */
    $query_count_apps = "SELECT COUNT(*) AS total FROM applications 
                         JOIN offers ON offers.offer_id = applications.application_offer_id
                         WHERE offers.offer_company_id = :company_id
                         AND application_status NOT IN ('accepted', 'refused')";
    $result_count_apps = $PDO -> prepare($query_count_apps);
    $result_count_apps -> bindParam(":company_id", $company_id, PDO::PARAM_INT);
    $result_count_apps -> execute();
    $count_apps = $result_count_apps -> fetch(PDO::FETCH_ASSOC);
    $total_apps = $count_apps['total'];

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


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Gerer la correspondance des langues -->
        <?php
            // correspondance secteur anglais => français
            $sectors = [
                'administration' => 'Administration publique',
                'agriculture' => 'Agriculture / Agroalimentaire',
                'construction' => 'Construction / BTP',
                'communication' => 'Communication / Marketing',
                'commerce' => 'Commerce / Distribution',
                'education' => 'Éducation / Formation',
                'energy' => 'Énergie / Environnement',
                'finance' => 'Finance / Banque / Assurance',
                'health' => 'Santé / Médical',
                'hospitality' => 'Hôtellerie / Restauration',
                'industry' => 'Industrie / Production',
                'it' => 'Informatique / TIC',
                'law' => 'Juridique / Droit',
                'telecom' => 'Télécommunications',
                'transport' => 'Transport / Logistique'
            ];

            //Formater la date en francais 
            include '../utils/date_format.php';
            $date_fr = dateFormat($last_publication['offer_created_at']);
        ?>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section tableau de bord -->              
        <section class="dashboard">

            <!-- Les 3 cartes principales -->
            <div class="dashboard-card-header">

                <!-- Carte des offres publiées -->
                <a href="my_offers.php">
                    <div class="dashboard-card-box">
                        <i class="fa-solid fa-briefcase"></i>
                        <h4>Offre<?php if ($total_offers > 1) echo 's' ?? ''; ?> publiée<?php if ($total_offers > 1) echo 's' ?? ''; ?></h4>
                        <p><?php echo $total_offers; ?></p>
                    </div>
                </a>

                <!-- Carte des candidatures reçues -->
                <a href="applications_received.php?company_id=<?php echo $company['company_id']; ?>">
                    <div class="dashboard-card-box">
                        <i class="fa-solid fa-user-tie"></i>
                        <h4>Candidature<?php if ($total_apps > 1) echo 's' ?? ''; ?> reçue<?php if ($total_apps > 1) echo 's' ?? ''; ?></h4>
                        <p><?php echo $total_apps ?? 0; ?></p>
                    </div>
                </a>

                <!-- Carte dernière publication -->
                <div class="dashboard-card-box">
                    <i class="fa-solid fa-calendar-days"></i>
                    <h4>Dernière publication</h4>
                    <p class="last-publication"><?php if (!empty($last_publication['offer_created_at'])) echo 'Le ' ?? ''  ?><?php echo $date_fr ?? 'Aucune offre publiée'  ?></p>
                </div>

            </div>

            <!-- Partie contenu principal -->
            <div class="dashboard-card-container">

                <div class="dashboard-card-content left">

                    <h2>Dernière<?php if ($total_offers > 1) echo 's' ?? ''; ?> offre<?php if ($total_offers > 1) echo 's' ?? ''; ?> publiée<?php if ($total_offers > 1) echo 's' ?? ''; ?></h2>

                    <?php if ($total_offers === 0): ?>

                        <div class="no-offer">Aucune offre publiée pour le moment.</div>

                    <?php else: ?>

                        <?php foreach ($offers as $offer): ?>

                            <div class="dashboard-card">

                                <div class="dashboard-card-box">

                                    <h4><?php echo ucfirst(htmlspecialchars($offer['offer_title'])); ?></h4>
                                    <div class="dashboard-card-layer">
                                        <h5>
                                            <span>Secteur</span> : 
                                            <?php 
                                                $sector = $offer['offer_sector'];
                                                echo htmlspecialchars($sectors[$sector]); 
                                            ?>
                                        </h5>
                                    </div>

                                </div>

                                <div class="dashboard-card-box aside">
                                    <a href="offer_details.php?id=<?php echo $offer['offer_id']; ?>">Voir</a>
                                    <a href="drop_offer.php?id=<?php echo $offer['offer_id']; ?>" class="offer-delete">Supprimer</a>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

                <div class="dashboard-card-content right">
                    
                    <a href="offer.php">
                        <div class="aside-card-box" >
                            <i class="fa-solid fa-plus"></i>
                            <p>Publier une nouvelle offre</p>
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
                    <!-- La boîte de confirmation de suppression -->
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
