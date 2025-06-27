
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(0);
ini_set('display_errors', 0);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Inclure le fichier de configuration
require_once '../config/db-config.php';

/*-------------------------------------------------------*/
// Recuperation des variables de session
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$session_id = $_SESSION['user-id'] ?? null;
$session_role = $_SESSION['role'];

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Recuperation de l'id de l'utilisateur
$user = null ;
$is_owner = false;

// Récupérer l'id à afficher
$displayed_id = isset($_GET['id']) ? intval($_GET['id']) : $session_id;

//Si l'id est fourni
if ($displayed_id){
    require_once '../config/db-config.php';

    // Récupérer les donnees de l'utilisateur
    $query_user = "SELECT * FROM users WHERE user_id = :user_id";
    $result = $PDO -> prepare($query_user);
    $result -> bindParam(":user_id", $displayed_id, PDO::PARAM_INT);
    $result -> execute();
    $user = $result -> fetch(PDO::FETCH_ASSOC);

    // Vérifier si c'est bien le propriétaire qui est connecté
    if ($session_id && $session_role == 'admin' && $user){
        $is_owner = ($user['user_id'] == $session_id);
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
                    <!-- Section d'affichage des informations du profil -->
        <section class="profil-info">

            <h2>Mon profil</h2>

            <div class="profil-info-container">

                <!-- Nom -->
                <div class="profil-info-box heading">
                    <div class="avatar-circle"><?= strtoupper($user['user_name'][0] ?? '') ?></div>
                    <h3 class="profil-info-name"><?= ucfirst(htmlspecialchars($user['user_name'])) ?></h3>
                </div>

                <!-- Email -->
               <div class="profil-info-box">
                    <i class="bx bxs-envelope" title="Email"></i>
                    <p><?= htmlspecialchars($user['user_email'] ?? 'Non renseigné'); ?></p>
                </div>

                <!-- Bouton de modification si propriétaire -->
                <?php if ($is_owner) :?>
                    <a href="../includes/edit_profil_admin.php" class="edit-prpfil-btn">Modifier les informations du compte</a>
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