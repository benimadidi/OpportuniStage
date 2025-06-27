
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(0);
ini_set('display_errors', 0);

/*-------------------------------------------------------*/
// Récupération de l'ID de l'offre passée en GET
$offer_id = $_GET['id'] ?? null;
$offer = null ;

//Si l'offre existe
if ($offer_id){
    require_once '../config/db-config.php';

    // Préparation de la requête SQL pour récupérer l'offre
    $sql = "SELECT * FROM offers WHERE offer_id = :offer_id";
    $result = $PDO -> prepare($sql);
    $result -> bindParam(":offer_id", $offer_id, PDO::PARAM_INT);
    $result -> execute();
    $offer = $result -> fetch(PDO::FETCH_ASSOC);
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
            $date_fr = dateFormat($offer['offer_deadline']);
        ?>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section contenant les détails de l'offre -->
        <section class="offer-details">

            <?php if ($offer): ?>

                <!-- Si l'offre existe -->
                <div class="offer-details-container">

                    <h2><?php echo htmlspecialchars(ucfirst($offer['offer_title'])); ?></h2>

                    <div class="offer-details-box">
                        
                        <!-- Lieu -->
                        <p><span>Lieu :</span> <?php echo htmlspecialchars($offer['offer_location']); ?></p>

                        <!-- Secteur et type -->
                        <p>
                            <span>Secteur :</span>
                            <?php
                                $sector = $offer['offer_sector'] ?? '';
                                echo htmlspecialchars($sectors[$sector] ?? $sector); 
                            ?>
                        </p>

                        <p>
                            <span>Type :</span>
                            <?php 
                                $type = $offer['offer_type'] ?? '';
                                echo htmlspecialchars($types[$type] ?? $type);
                            ?>
                        </p>

                        <!--Durée et date limite -->
                        <p><span>Durée :</span> <?php echo htmlspecialchars($offer['offer_duration']); ?> semaine<?php echo $offer['offer_duration'] > 1 ? 's' : ''; ?></p>
                        <p><span>Date limite :</span> <?php echo htmlspecialchars($date_fr); ?></p>

                        <!-- Profil et remunération -->
                        <p><span>Profil recherché :</span> <?php echo htmlspecialchars($offer['offer_profile']); ?></p>
                        <p><span>Rémunération/Semaine :</span> <?php echo htmlspecialchars($offer['offer_remuneration'] ? $offer['offer_remuneration'] : 'Non rémunéré'); ?><?php echo $offer['offer_remuneration'] ? ' USD' : ''; ?></p>

                        <!-- Description -->
                        <p><span>Description :</span><?php echo htmlspecialchars($offer['offer_description']); ?></p>

                    </div>


                </div>

            <?php else: ?>

                <!-- Si l'offre est introuvable -->
                <div class="alert error">Offre introuvable.</div>

            <?php endif; ?>

            <!-- Bouton retour -->
            <a href="my_offers.php" class="btn">Retour à mes offres</a>

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