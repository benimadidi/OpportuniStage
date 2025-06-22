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
$session_id = $_SESSION['student-id'] ?? null;

/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
// Recuperation de l'id de l'utilisateur
$user_id = $_SESSION['user-id'] ?? null;
$user = null;
$student = null;

if ($user_id){
    require_once '../config/db-config.php';

    //Récupérer les données de l'utilisateur
    $query_user = "SELECT * FROM users WHERE user_id = :user_id";
    $result = $PDO->prepare($query_user);
    $result->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result->execute();
    $user = $result->fetch(PDO::FETCH_ASSOC);

    //Récupérer les données de l'étudiant
    $query_student = "SELECT * FROM students WHERE student_user_id = :user_id";
    $result = $PDO->prepare($query_student);
    $result->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result->execute();
    $student = $result->fetch(PDO::FETCH_ASSOC);
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

            // Correspondance des niveaux d'etudes
            $levels = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3',
                'master_1' => 'Master 1',
                'master_2' => 'Master 2'
            ];

            //Formater la date en francais
            $date_birth = null;
            if (!empty($student['student_birthdate'])) {
                $date = new DateTime($student['student_birthdate']);
                $formatter = new IntlDateFormatter(
                    'fr_FR',
                    IntlDateFormatter::LONG,
                    IntlDateFormatter::NONE,
                    'Africa/Kinshasa',
                    IntlDateFormatter::GREGORIAN,
                    'd MMMM yyyy'
                );
                $date_birth = $formatter->format($date);
            }

        ?>


        <section class="profil-info">

            <h2>Mon profil étudiant</h2>

            <div class="profil-info-container">

                <div class="profil-info-box heading">
                    <div class="avatar-circle"><?= strtoupper($student['student_name'][0] ?? $session_name[0] ?? '') ?></div>
                    <h3 class="profil-info-name"><?= htmlspecialchars($student['student_name'] ?? $session_name ?? '') ?></h3>
                </div>

                <div class="profil-info-box">
                    <i class="bx bxs-envelope" title="Email"></i>
                    <p><a href="mailto:<?= htmlspecialchars($user['user_email'] ?? '#') ?>"><?= htmlspecialchars($user['user_email'] ?? 'Non renseigné') ?></a></p>
                </div>

                <div class="profil-info-box">
                    <i class="bx bxs-school" title="Université"></i>
                    <p><?= htmlspecialchars($student['student_university'] ?? 'Non renseigné') ?></p>
                </div>

                <div class="profil-info-box">
                    <i class="bx bxs-book" title="Domaine d’études"></i>
                    <p>
                        <?php
                            $field = $student['student_field'] ?? null;
                            echo htmlspecialchars($fields[$field] ?? 'Non renseigné') 
                        ?>
                    </p>
                </div>

                <div class="profil-info-box">
                    <i class="fa-solid fa-graduation-cap" title="Niveau d’études"></i>
                    <p>
                        <?php
                            $level = $student['student_level'] ?? null;
                            echo htmlspecialchars($levels[$level] ?? 'Non renseigné') 
                        ?>
                    </p>
                </div>

                <div class="profil-info-box">
                    <i class="bx bxs-phone" title="Téléphone"></i>
                    <p><?= htmlspecialchars($student['student_phone_number'] ?? 'Non renseigné') ?></p>
                </div>

                <div class="profil-info-box">
                    <i class="fa-solid fa-cake-candles" title="Date de naissance"></i>
                    <p><?php  echo $date_birth ? 'Le ' : '';  ?> <?= htmlspecialchars($date_birth ?? 'Non renseigné') ?></p>
                </div>

                <div class="profil-info-box description-box">
                    <i class="fa-solid fa-comment-dots" title="A propos de moi"></i>
                    <p><?= htmlspecialchars($student['student_about'] ?? 'Pas de description') ?></p>
                </div>

                <div class="profil-info-box last">
                    <i class="bx bxs-file" title="CV"></i>
                    <?php if (!empty($student['student_cv']) && file_exists($student['student_cv'])): ?>
                        <a href="<?= htmlspecialchars($student['student_cv']) ?>" target="_blank" class="cv-link">Voir mon CV</a>
                    <?php else: ?>
                        <p>CV non disponible</p>
                    <?php endif; ?>
                </div>

                <a href="../includes/edit_profil_2.php" class="edit-prpfil-btn">Modifier les informations du compte</a>

            </div>

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
