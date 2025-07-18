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
$session_id = $_SESSION['student-id'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Récupération de l'identifiant de l'offre passé dans l'URL
$offer_id = $_GET['id'] ?? null;
$offer = null;

if ($offer_id) {
    require_once '../config/db-config.php';

    // Préparation et exécution de la requête de récupération de l'offre
    $sql = "SELECT offers.*, companies.company_name, companies.company_user_id
            FROM offers
            JOIN companies
            ON companies.company_id = offers.offer_company_id
            WHERE offer_id = :offer_id";
    $result = $PDO->prepare($sql);
    $result->bindParam(":offer_id", $offer_id, PDO::PARAM_INT);
    $result->execute();
    $offer = $result->fetch(PDO::FETCH_ASSOC);
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

            // correspondance type anglais => français
            $types = [
                'full-time' => 'Temps plein',
                'part-time' => 'Temps partiel'
            ];

            //Formater la date en francais 
            include '../utils/date_format.php';
            $date_fr =dateFormat($offer['offer_deadline']);
        ?>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section principale : affichage des offres -->
        <section class="offer-details">

            <?php if ($offer): ?>

                <div class="offer-details-container">

                    <!-- Titre de l'offre -->
                    <h2><?php echo htmlspecialchars(ucfirst($offer['offer_title'])); ?></h2>

                    <div class="offer-details-box">

                        <!-- Nom de l'entreprise avec lien vers son profil -->
                        <p><span>Entreprise :</span><a href="../company/profil.php?id=<?php echo $offer['company_user_id']; ?>" class="company-link"> <?php echo htmlspecialchars($offer['company_name']); ?></a></p>

                        <!-- Lieu du stage -->
                        <p><span>Lieu :</span> <?php echo htmlspecialchars($offer['offer_location']); ?></p>

                        <!-- Secteur d'activité -->
                        <p>
                            <span>Secteur :</span>
                            <?php
                            $sector = $offer['offer_sector'] ?? '';
                            echo htmlspecialchars($sectors[$sector] ?? $sector);
                            ?>
                        </p>

                        <!-- Type de stage -->
                        <p>
                            <span>Type :</span>
                            <?php
                            $type = $offer['offer_type'] ?? '';
                            echo htmlspecialchars($types[$type] ?? $type);
                            ?>
                        </p>

                        <!-- Durée en semaines -->
                        <p><span>Durée :</span> <?php echo htmlspecialchars($offer['offer_duration']); ?> semaine<?php echo $offer['offer_duration'] > 1 ? 's' : ''; ?></p>

                        <!-- Date de fin -->
                        <p><span>Date limite :</span> <?php echo htmlspecialchars($date_fr); ?></p>

                        <!-- Profil rechercher -->
                        <p><span>Profil recherché :</span> <?php echo htmlspecialchars($offer['offer_profile']); ?></p>

                        <!-- Rémunération par semaine -->
                        <p><span>Rémunération/Semaine :</span> <?php echo htmlspecialchars($offer['offer_remuneration'] ? $offer['offer_remuneration'] : 'Non rémunéré'); ?><?php echo $offer['offer_remuneration'] ? ' USD' : ''; ?></p>

                        <!-- Description de l'offre -->
                        <p><span>Description :</span> <?php echo htmlspecialchars($offer['offer_description']); ?></p>

                    </div>


                </div>

            <?php else: ?>

                <div class="alert error">Offre introuvable.</div>

            <?php endif; ?>

            <!-- Boutons d'action en bas de page -->
            <div class="offer-action-btn">
                <a href="offers.php" class="btn">Retour aux offres</a>
                <a href="../controllers/offer_details_process.php?id=<?= $offer['offer_id'] ?>" class="btn">Postuler</a>
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