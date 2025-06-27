
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

// Si un utilisateur est connecté
if ($user_id){
    // Inclusion de la configuration de la base de données
    require_once '../config/db-config.php';

    // Prépare une requête pour récupérer les informations de l'utilisateur
    $query_user = "SELECT * FROM users WHERE user_id = :user_id";
    $result = $PDO -> prepare($query_user);
    $result -> bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result -> execute();
    $user = $result -> fetch(PDO::FETCH_ASSOC);
}

/*-------------------------------------------------------*/
// Suppression des variables de session
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


        <section class="edit-profil">

            <h2>Modifier les informations du compte</h2>

            <!-- Formulaire d'édition du profil -->
            <form action="../controllers/edit_profil_process_2.php" method="POST">

                 <!-- Champ nouvelle adresse email prérempli avec l'email actuel -->
                <div class="edit-profil-input-box">
                    <label for="user-new-email">Nouvelle adresse email</label>
                    <input type="email" name="user-new-email" id="user-new-email" value="<?php echo htmlspecialchars($user['user_email'] ?? ''); ?>">
                </div>

                <!-- Champ nouveau mot de passe -->
                <div class="edit-profil-input-box">
                    <label for="user-new-password">Nouveau mot de passe</label>
                    <input type="password" name="user-new-password" id="user-new-password" required>
                </div>

                <!-- Champ confirmation du nouveau mot de passe -->
                <div class="edit-profil-input-box">
                    <label for="user-new-email-confirm">Confirmer le mot de passe</label>
                    <input type="password" name="user-new-password-confirm" id="user-new-password-confirm" required>
                </div>

                <!-- Bouton pour valider le formulaire -->
                <button type="submit" name="edit-profil-btn" class="edit-profil-btn">Modifier</button>

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