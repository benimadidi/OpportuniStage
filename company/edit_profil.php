
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
$session_id = $_SESSION['user-id'] ?? null;
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];

/*-------------------------------------------------------*/
// Suppression des variables de session
session_unset();

/*-------------------------------------------------------*/
// Enregistrement des variables de session
if ($session_name !== null)
    $_SESSION['name'] = $session_name ;
if ($session_id > 0)
    $_SESSION['user-id'] = $session_id;

?>

<!DOCTYPE html>
<html lang="fr">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpportuniSatge - Edit Profil</title>

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
                    <!-- Formulaire de modification -->
        <section class="edit-profil">

            <h2>Modifier votre profil</h2>

            <form action="../controllers/edit_profil_process.php" method="POST">

                <div class="edit-profil-input-box">
                    <label for="company-name">Nom de l'entreprise</label>
                    <input type="text" name="company-name" id="company-name">
                </div>

                <div class="edit-profil-input-box">
                    <label for="company-tel">Numéro de téléphone</label>
                    <input type="tel" name="company-tel" id="company-tel" value="<?php ?>">
                </div>

                <div class="edit-profil-input-box">
                    <label for="company-sector">Activité principale</label>
                    <select name="company-sector" id="company-sector" required>
                        <option value="" disabled selected>Selectionnez votre domaine d'activité</option>
                        <option value="administration">Administration publique</option>
                        <option value="agriculture">Agriculture / Agroalimentaire</option>
                        <option value="construction">Construction / BTP</option>
                        <option value="communication">Communication / Marketing</option>
                        <option value="commerce">Commerce / Distribution</option>
                        <option value="education">Éducation / Formation</option>
                        <option value="energy">Énergie / Environnement</option>
                        <option value="finance">Finance / Banque / Assurance</option>
                        <option value="health">Santé / Médical</option>
                        <option value="hospitality">Hôtellerie / Restauration</option>
                        <option value="industry">Industrie / Production</option>
                        <option value="it">Informatique / TIC</option>
                        <option value="law">Juridique / Droit</option>
                        <option value="telecom">Télécommunications</option>
                        <option value="transport">Transport / Logistique</option>
                    </select>
                </div>

                <div class="edit-profil-input-box">
                    <label for="company-size">Taille</label>
                    <select name="company-size" id="company-size">
                        <option value="micro">Micro-entreprise (moins de 10 personnes)</option>
                        <option value="small">Petite entreprise (10 à 50 personnes)</option>
                        <option value="medium">Moyenne entreprise (50 à 250 personnes)</option>
                        <option value="large">Grande entreprise (plus de 250 personnes)</option>
                    </select>
                </div>

                <div class="edit-profil-input-box">
                    <label for="company-description">Description</label>
                    <textarea name="company-description" id="company-description" cols="30" rows="10"></textarea>
                </div>

                <div class="edit-profil-input-box">
                    <label for="company-website">Site web</label>
                    <input type="text" name="company-website" id="company-website" placeholder="https://masociete.cd">
                </div>

                <div class="edit-profil-input-box">
                    <label for="company-address">Adresse</label>
                    <input type="text" name="company-address" id="company-address">
                </div>

                <button type="submit" name="edit-profil-btn" class="edit-profil-btn">Modifier</button>
                
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
        <script src="./assets/js/script.js"></script>

    </body>

</html>