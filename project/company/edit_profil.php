
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
$session_id = $_SESSION['user-id'] ?? null;
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? []; 

/*-------------------------------------------------------*/
// Recuperation de l'id de l'utilisateur
$user_id = $_SESSION['user-id'] ?? null;
$user = null ;
$company = null;

if ($user_id){
    require_once '../config/db-config.php';

    //Récupérer les donnees de l'entreprise 
    $query_company = "SELECT * FROM companies WHERE company_user_id = :user_id";
    $result = $PDO -> prepare($query_company);
    $result -> bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result -> execute();
    $company = $result -> fetch(PDO::FETCH_ASSOC);
}

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

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


        <!--////////////////////////////////////////////////////-->
                    <!-- Section de modification du profil -->
        <section class="edit-profil">

            <h2>Mettre à jour votre profil entreprise</h2>

            <form action="../controllers/edit_profil_process.php" method="POST">

                <!-- Nom de l'entreprise -->
                <div class="edit-profil-input-box">
                    <label for="company-name">Nom de l'entreprise</label>
                    <input type="text" name="company-name" id="company-name" value="<?php echo htmlspecialchars($company['company_name'] ?? $session_name); ?>" >
                </div>

                <!-- Numéro de téléphone -->
                <div class="edit-profil-input-box">
                    <label for="company-tel">Numéro de téléphone</label>
                    <input type="tel" name="company-tel" id="company-tel" value="<?php echo htmlspecialchars($company['company_phone_number'] ?? ''); ?> " >
                </div>

                <!-- Secteur d'activité -->
                <div class="edit-profil-input-box">
                    <label for="company-sector">Activité principale</label>
                    <select name="company-sector" id="company-sector" >
                        <option value="" disabled <?php if (empty($company['company_sector'])) echo 'selected'; ?>>Selectionnez votre domaine d'activité</option>
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

                <!-- Taille de l'entreprise -->
                <div class="edit-profil-input-box">
                    <label for="company-size">Taille</label>
                    <select name="company-size" id="company-size" >
                        <option value="micro" <?php if (($company['company_size'] ?? '' ) === 'micro') echo 'selected'; ?>>Micro-entreprise (moins de 10 personnes)</option>
                        <option value="small" <?php if (($company['company_size'] ?? '' ) === 'small') echo 'selected'; ?>>Petite entreprise (10 à 50 personnes)</option>
                        <option value="medium" <?php if (($company['company_size'] ?? '' ) === 'medium') echo 'selected'; ?>>Moyenne entreprise (50 à 250 personnes)</option>
                        <option value="large" <?php if (($company['company_size'] ?? '' ) === 'large') echo 'selected'; ?>>Grande entreprise (plus de 250 personnes)</option>
                    </select>

                </div>

                <!-- Description -->
                <div class="edit-profil-input-box">
                    <label for="company-description">Description</label>
                    <textarea name="company-description" id="company-description" cols="30" rows="10" ><?php echo htmlspecialchars($company['company_description'] ?? ''); ?></textarea>
                </div>

                <!-- Site web -->
                <div class="edit-profil-input-box">
                    <label for="company-website">Site web</label>
                    <input type="text" name="company-website" id="company-website" placeholder="https://www.masociete.cd" value="<?php echo htmlspecialchars($company['company_website'] ?? ''); ?>" >
                </div>

                <!-- Adresse -->
                <div class="edit-profil-input-box">
                    <label for="company-address">Adresse</label>
                    <input type="text" name="company-address" id="company-addres" value="<?php echo htmlspecialchars($company['company_address'] ?? ''); ?>" >
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" name="edit-profil-btn" class="edit-profil-btn">Modifier</button>
                
            </form>

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