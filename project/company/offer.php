
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Recuperation des variables de session
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$session_id = $_SESSION['user-id'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Initialiser les infos de l'entreprise a null
$company = null ;

if ($session_id){
    require_once '../config/db-config.php';

    //Récupérer les donnees de l'entreprise 
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
                    <!-- Header de l'entreprise -->
        <header class="header">

            <a href="#" class="logo">OpportuniStage</a>

            <i class='bx   bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="dashboard.php">Tableau de bord</a>
                <a href="my_offers.php">Mes offres</a>
                <a href="#"  class="active">Publier une offre</a>
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

        <!--////////////////////////////////////////////////////-->
                    <!--alerts-->
        <?php include '../includes/alerts.php' ?>


        <!--////////////////////////////////////////////////////-->
                    <!-- Formulaire de publication -->

        <section class="add-offer">

            <h2>Publier une offre</h2>

            <form action="../controllers/offer_process.php" method="POST">
                <div class="add-offer-input-box">
                    <label for="offer-title">Titre de l'offre</label>
                    <input type="text" name="offer-title" id="offer-title" required>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-description">Description de l'offre</label>
                    <input type="text" name="offer-description" id="offer-description" required>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-location">Lieu de l'offre</label>
                    <input type="text" name="offer-location" id="offer-location" value="<?php echo htmlspecialchars($company['company_address'] ?? ''); ?>" required>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-sector">Secteur d'activité</label>
                    <select name="offer-sector" id="offer-sector">
                        <option value="" disabled <?php if (empty($company['company_sector'])) echo 'selected'; ?>>-- Sélectionner un secteur --</option>
                        <option value="administration" <?php if (($company['company_sector'] ?? '') === 'administration') echo 'selected'; ?>>Administration publique</option>
                        <option value="agriculture" <?php if (($company['company_sector'] ?? '') === 'agriculture') echo 'selected'; ?>>Agriculture / Agroalimentaire</option>
                        <option value="construction" <?php if (($company['company_sector'] ?? '') === 'construction') echo 'selected'; ?>>Construction / BTP</option>
                        <option value="communication" <?php if (($company['company_sector'] ?? '') === 'communication') echo 'selected'; ?>>Communication / Marketing</option>
                        <option value="commerce" <?php if (($company['company_sector'] ?? '') === 'commerce') echo 'selected'; ?>>Commerce / Distribution</option>
                        <option value="education" <?php if (($company['company_sector'] ?? '') === 'education') echo 'selected'; ?>>Éducation / Formation</option>
                        <option value="energy" <?php if (($company['company_sector'] ?? '') === 'energy') echo 'selected'; ?>>Énergie / Environnement</option>
                        <option value="finance" <?php if (($company['company_sector'] ?? '') === 'finance') echo 'selected'; ?>>Finance / Banque / Assurance</option>
                        <option value="health" <?php if (($company['company_sector'] ?? '') === 'health') echo 'selected'; ?>>Santé / Médical</option>
                        <option value="hospitality" <?php if (($company['company_sector'] ?? '') === 'hospitality') echo 'selected'; ?>>Hôtellerie / Restauration</option>
                        <option value="industry" <?php if (($company['company_sector'] ?? '') === 'industry') echo 'selected'; ?>>Industrie / Production</option>
                        <option value="it" <?php if (($company['company_sector'] ?? '') === 'it') echo 'selected'; ?>>Informatique / TIC</option>
                        <option value="law" <?php if (($company['company_sector'] ?? '') === 'law') echo 'selected'; ?>>Juridique / Droit</option>
                        <option value="telecom" <?php if (($company['company_sector'] ?? '') === 'telecom') echo 'selected'; ?>>Télécommunications</option>
                        <option value="transport" <?php if (($company['company_sector'] ?? '') === 'transport') echo 'selected'; ?>>Transport / Logistique</option>
                    </select>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-type">Type d'offre</label>
                    <select name="offer-type" id="offer-type" required>
                        <option value="" disabled selected>-- Type d'offre --</option>
                        <option value="full-time">Temps plein</option>
                        <option value="part-time">Temps partiel</option>
                    </select>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-duration">Duree de l'offre</label>
                    <input type="number" name="offer-duration" id="offer-duration" required placeholder="En semaines">
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-deadline">Date limite de candidature</label>
                    <input type="date" name="offer-deadline" id="offer-deadline" required>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-profile">Profil recherché</label>
                    <textarea name="offer-profile" id="offer-profile" cols="30" rows="4" required></textarea>
                </div>

                <div class="add-offer-input-box">
                    <label for="offer-remuneration">Rémuneration(Optionnel)</label>
                    <input type="number" name="offer-remuneration" id="offer-remuneration" placeholder="montant par semaine (USD)">
                </div>

                <button type="submit" name="add-offer-btn" class="add-offer-btn">Publier l'offre</button>

            </form>

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
