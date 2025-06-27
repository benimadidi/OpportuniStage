
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
$session_role = $_SESSION['role'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Initialisation des variables
$user = null ;
$company = null;
$is_owner = false;

// Récupérer l'id à afficher
$displayed_id = isset($_GET['id']) ? intval($_GET['id']) : $session_id;

if ($displayed_id){
    require_once '../config/db-config.php';

    // Récupérer les données de la table users
    $query_user = "SELECT * FROM users WHERE user_id = :user_id";
    $result = $PDO -> prepare($query_user);
    $result -> bindParam(":user_id", $displayed_id, PDO::PARAM_INT);
    $result -> execute();
    $user = $result -> fetch(PDO::FETCH_ASSOC);

    // Récupérer les données spécifiques de la table companies
    $query_company = "SELECT * FROM companies WHERE company_user_id = :user_id";
    $result = $PDO -> prepare($query_company);
    $result -> bindParam(":user_id", $displayed_id, PDO::PARAM_INT);
    $result -> execute();
    $company = $result -> fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur connecté est le propriétaire du profil
    if ($session_id && $session_role == 'company' && $company){
        $is_owner = ($company['company_user_id'] == $session_id);
    }
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

            // Correspondance taille 
            $sizes = [
                'micro' => 'Micro-entreprise (moins de 10 personnes)',
                'small' => 'Petite entreprise (10 à 50 personnes)',
                'medium' => 'Moyenne entreprise (50 à 250 personnes)',
                'large' => 'Grande entreprise (plus de 250 personnes)'
            ];

            //Formater la date en francais 
            include '../utils/date_format.php';
            $date_fr = dateFormat($company['company_created_at']);

        ?>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section d'affichage des informations du profil -->
        <section class="profil-info">

            <h2>Mon profil</h2>

            <div class="profil-info-container">

                <div class="profil-info-box heading">
                    <div class="avatar-circle"><?= strtoupper($company['company_name'][0] ?? $session_name[0] ?? '')?></div>
                    <h3 class="profil-info-name"><?php echo ucfirst(htmlspecialchars($company['company_name'] ?? $session_name)); ?></h3>
                </div>

                <!-- Email -->
                <div class="profil-info-box">
                    <i class="bx  bxs-envelope" title="Email"></i>
                    <p><?php echo htmlspecialchars($user['user_email'] ?? 'Non renseigné'); ?></p>
                </div>

                <!-- Téléphone -->
                <div class="profil-info-box">
                    <i class='bxr  bxs-phone' title="Numéro de télépone" ></i> 
                    <p><?php echo htmlspecialchars($company['company_phone_number'] ?? 'Non renseigné'); ?></p>
                </div>

                <!-- Secteur d'activité -->
                <div class="profil-info-box">
                    <i class='bx bxs-briefcase' title="Secteur d'activité"></i>
                    <p>
                        <?php
                            $sector = $company['company_sector'];
                            echo htmlspecialchars( $sectors[$sector] ?? 'Non renseigné'); 
                        ?>
                    </p>
                </div>

                 <!-- Taille de l'entreprise -->
                <div class="profil-info-box">
                    <i class="fa-solid fa-maximize" title="Taille de l'entreprise"></i>
                    <p>
                        <?php 
                            $size = $company['company_size'];
                            echo htmlspecialchars($sizes[$size] ?? 'Non renseigné');
                        ?>
                    </p>
                </div>

                <!-- Description -->
                <div class="profil-info-box">
                    <i class='bx bxs-building' title="Description"></i>
                    <p><?php echo ucfirst(htmlspecialchars($company['company_description'] ?? 'Pas de description')) ; ?></p>
                </div>

                <!-- Site web -->
                <div class="profil-info-box">
                    <i class='bxr  bxs-link' title="Site web" ></i> 
                    <a href="<?php echo htmlspecialchars($company['company_website'] ?? '') ; ?>" target="_blank"><?php echo htmlspecialchars($company['company_website'] ?? 'Non renseigné') ; ?></a>
                </div>

                <!-- Adresse -->
                <div class="profil-info-box">
                    <i class="fa-solid fa-map-location-dot" title="Adresse"></i>
                    <p><?php echo htmlspecialchars($company['company_address'] ?? "Non renseigné") ; ?></a>
                </div>

                <!-- Date de création -->
                <div class="profil-info-box last">
                    <i class='bx bxs-calendar' title="Date de création"></i> 
                    <p>Créé le <?php echo htmlspecialchars($date_fr ?? '') ; ?></p>
                </div>
                
                <!-- Bouton de modification si propriétaire -->
                <?php if ($is_owner) :?>
                    <a href="../includes/edit_profil_2.php" class="edit-prpfil-btn">Modifier les informations du compte</a>
                <?php endif; ?>

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