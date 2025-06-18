
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
        ?>

        <section class="offer-details-page">

            <?php if ($offer): ?>

                <div class="offer-details-card">

                    <h2><?php echo htmlspecialchars($offer['offer_title']); ?></h2>

                    <p><strong>Description :</strong> <?php echo htmlspecialchars($offer['offer_description']); ?></p>

                    <p><strong>Lieu :</strong> <?php echo htmlspecialchars($offer['offer_location']); ?></p>

                    <p><strong>Secteur :</strong>
                    <?php
                        $sector = $offer['offer_sector'] ?? '';
                        echo htmlspecialchars($sectors[$sector] ?? $sector); 
                    ?></p>

                    <p><strong>Type :</strong>
                    <?php 
                        $type = $offer['offer_type'] ?? '';
                        echo htmlspecialchars($types[$type] ?? $type);
                    ?></p>

                    <p><strong>Durée :</strong> <?php echo htmlspecialchars($offer['offer_duration']); ?></p>
                    
                    <p><strong>Date limite :</strong> <?php echo htmlspecialchars($offer['offer_deadline']); ?></p>

                    <p><strong>Profil recherché :</strong> <?php echo htmlspecialchars($offer['offer_profile']); ?></p>

                    <p><strong>Rémunération :</strong> <?php echo htmlspecialchars($offer['offer_remuneration']); ?></p>

                </div>

            <?php else: ?>

                <div class="alert alert-error">Offre introuvable.</div>

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