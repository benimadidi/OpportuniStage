
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

/*-------------------------------------------------------*/
// Recuperation de l'id de l'offre
$offer_id = $_GET['id'] ?? null;
$offer = null ;

if ($offer_id){
    require_once '../config/db-config.php';

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
            $date = new DateTime($offer['offer_deadline']);
            $formatter = new IntlDateFormatter(
                'fr_FR',
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                'Africa/Kinshasa',
                IntlDateFormatter::GREGORIAN,
                'd MMMM yyyy'
            );
            $date_fr = $formatter->format($date);
        ?>

        <section class="offer-details">

            <?php if ($offer): ?>

                <div class="offer-details-container">

                    <h2><?php echo htmlspecialchars(ucfirst($offer['offer_title'])); ?></h2>

                    <div class="offer-details-box">
                        
                        <p><span>Lieu :</span> <?php echo htmlspecialchars($offer['offer_location']); ?></p>
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
                        <p><span>Durée :</span> <?php echo htmlspecialchars($offer['offer_duration']); ?> semaine<?php echo $offer['offer_duration'] > 1 ? 's' : ''; ?></p>
                        <p><span>Date limite :</span> <?php echo htmlspecialchars($date_fr); ?></p>
                        <p><span>Profil recherché :</span> <?php echo htmlspecialchars($offer['offer_profile']); ?></p>
                        <p><span>Rémunération/Semaine :</span> <?php echo htmlspecialchars($offer['offer_remuneration'] ? $offer['offer_remuneration'] : 'Non rémunéré'); ?><?php echo $offer['offer_remuneration'] ? ' USD' : ''; ?></p>
                        <p><span>Description :</span><?php echo htmlspecialchars($offer['offer_description']); ?></p>

                    </div>


                </div>

            <?php else: ?>

                <div class="alert error">Offre introuvable.</div>

            <?php endif; ?>

            <a href="my_offers.php" class="btn">Retour à mes offres</a>

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