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
$session_id = $_SESSION['user-id'] ?? null;
$session_role = $_SESSION['role'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Initialisation des variables
$is_owner = false;
$user = null;
$student = null;

// Récupérer l'id à afficher
$displayed_id = isset($_GET['id']) ? intval($_GET['id']) : $session_id;

// Si un ID est défini 
if ($displayed_id){
    require_once '../config/db-config.php';

    // Récupérer les données de la table users
    $query_user = "SELECT * FROM users WHERE user_id = :user_id";
    $result = $PDO->prepare($query_user);
    $result -> bindParam(":user_id", $displayed_id, PDO::PARAM_INT);
    $result -> execute();
    $user = $result -> fetch(PDO::FETCH_ASSOC);

    // Récupérer les données spécifiques de la table students
    $query_student = "SELECT * FROM students WHERE student_user_id = :user_id";
    $result = $PDO -> prepare($query_student);
    $result -> bindParam(":user_id", $displayed_id, PDO::PARAM_INT);
    $result -> execute();
    $student = $result -> fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur connecté est bien le propriétaire du profil
    if ($session_id && $session_role == 'student' && $student){
        $is_owner = ($student['student_user_id'] == $session_id);
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
                    <!-- Gerer la correspondance des langues -->
        <?php
            /*-------------------------------------------------------*/
            // Correspondance des domaines
            $fields = [
                'computer_science' => 'Informatique',
                'management' => 'Gestion',
                'law' => 'Droit',
                'economics' => 'Économie',
                'medicine' => 'Médecine',
                'communication' => 'Communication',
                'social_sciences' => 'Sciences sociales'
            ];

            /*-------------------------------------------------------*/
            // Correspondance des niveaux d'etudes
            $levels = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3',
                'master_1' => 'Master 1',
                'master_2' => 'Master 2'
            ];

            /*-------------------------------------------------------*/
            /*Inclure la fonction du formatage de la date*/
            include '../utils/date_format.php';

            $date_birth = dateFormat($student['student_birthdate'] ?? null);

        ?>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section d'affichage des informations du profil -->
        <section class="profil-info">

            <h2>Mon profil étudiant</h2>

            <div class="profil-info-container">

                <!-- Avatar et nom -->
                <div class="profil-info-box heading">
                    <div class="avatar-circle"><?= strtoupper($student['student_name'][0] ?? $session_name[0] ?? '') ?></div>
                    <h3 class="profil-info-name"><?= htmlspecialchars($student['student_name'] ?? $session_name ?? '') ?></h3>
                </div>

                <!-- Email -->
                <div class="profil-info-box">
                    <i class="bx bxs-envelope" title="Email"></i>
                    <p><a href="mailto:<?= htmlspecialchars($user['user_email'] ?? '#') ?>"><?= htmlspecialchars($user['user_email'] ?? 'Non renseigné') ?></a></p>
                </div>

                <!-- Université -->
                <div class="profil-info-box">
                    <i class="bx bxs-school" title="Université"></i>
                    <p><?= htmlspecialchars($student['student_university'] ?? 'Non renseigné') ?></p>
                </div>

                <!-- Domaine d'études -->
                <div class="profil-info-box">
                    <i class="bx bxs-book" title="Domaine d’études"></i>
                    <p>
                        <?php
                            $field = $student['student_field'] ?? null;
                            echo htmlspecialchars($fields[$field] ?? 'Non renseigné') 
                        ?>
                    </p>
                </div>

                <!-- Niveau d'études -->
                <div class="profil-info-box">
                    <i class="fa-solid fa-graduation-cap" title="Niveau d’études"></i>
                    <p>
                        <?php
                            $level = $student['student_level'] ?? null;
                            echo htmlspecialchars($levels[$level] ?? 'Non renseigné') 
                        ?>
                    </p>
                </div>

                <!-- Téléphone -->
                <div class="profil-info-box">
                    <i class="bx bxs-phone" title="Téléphone"></i>
                    <p><?= htmlspecialchars($student['student_phone_number'] ?? 'Non renseigné') ?></p>
                </div>

                <!-- Date de naissance -->
                <div class="profil-info-box">
                    <i class="fa-solid fa-cake-candles" title="Date de naissance"></i>
                    <p><?php  echo $date_birth ? 'Le ' : '';  ?> <?= htmlspecialchars($date_birth ?? 'Non renseigné') ?></p>
                </div>

                <!-- À propos -->
                <div class="profil-info-box description-box">
                    <i class="fa-solid fa-comment-dots" title="A propos de vous"></i>
                    <p><?= htmlspecialchars($student['student_about'] ?? 'Pas de description') ?></p>
                </div>

                <!-- CV -->
                <div class="profil-info-box last">
                    <i class="bx bxs-file" title="CV"></i>
                    <?php if (!empty($student['student_cv']) && file_exists($student['student_cv'])): ?>
                        <a href="<?= htmlspecialchars($student['student_cv']) ?>" target="_blank">Voir mon CV</a>
                    <?php else: ?>
                        <p>CV non disponible</p>
                    <?php endif; ?>
                </div>

                <!-- Bouton de modification affiché seulement si c'est le propriétaire -->
                <?php if ($is_owner) :?>
                    <a href="../includes/edit_profil_2.php" class="edit-prpfil-btn">Modifier les informations du compte</a>
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