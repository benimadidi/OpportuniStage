
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
// Recuperation de l'id de l'utilisateur
$user_id = $_SESSION['user-id'] ?? null;
$user = null ;

if ($user_id){
    require_once '../config/db-config.php';

    //Récupérer les données de l'utilisateur
    $query_user = "SELECT * FROM users WHERE user_id = :user_id";
    $result = $PDO -> prepare($query_user);
    $result -> bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result -> execute();
    $user = $result -> fetch(PDO::FETCH_ASSOC);
}

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


        <section class="edit-profil">

            <h2>Modifier les informations du compte</h2>

            <form action="../controllers/edit_profil_process_2.php" method="POST">

                <div class="edit-profil-input-box">
                    <label for="user-new-email">Nouvelle adresse email</label>
                    <input type="email" name="user-new-email" id="user-new-email" value="<?php echo htmlspecialchars($user['user_email'] ?? ''); ?>">
                </div>

                <div class="edit-profil-input-box">
                    <label for="user-new-password">Nouveau mot de passe</label>
                    <input type="password" name="user-new-password" id="user-new-password" required>
                </div>

                <div class="edit-profil-input-box">
                    <label for="user-new-email-confirm">Confirmer le mot de passe</label>
                    <input type="password" name="user-new-password-confirm" id="user-new-password-confirm" required>
                </div>

                <button type="submit" name="edit-profil-btn" class="edit-profil-btn">Modifier</button>

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