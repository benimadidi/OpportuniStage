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
$user_id = $session_id;
$student = null;

if ($user_id) {
    require_once '../config/db-config.php';

    //Récupérer les donnees de l'etudiant 
    $query_student = "SELECT * FROM students WHERE student_user_id = :user_id";
    $result = $PDO->prepare($query_student);
    $result->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result->execute();
    $student = $result->fetch(PDO::FETCH_ASSOC);
}

/*-------------------------------------------------------*/
// Suppression des variables de session
session_unset();

/*-------------------------------------------------------*/
// Enregistrement des variables de session
if ($session_name !== null)
    $_SESSION['name'] = $session_name;
if ($session_id > 0)
    $_SESSION['user-id'] = $session_id;

?>

<!DOCTYPE html>
<html lang="fr">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpportuniStage - Modifier Profil Étudiant</title>

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

            <h2>Modifier votre profil étudiant</h2>

            <form action="../controllers/edit_profil_process.php" method="POST" enctype="multipart/form-data">

                <div class="edit-profil-input-box">
                    <label for="student-name">Nom complet</label>
                    <input type="text" name="student-name" id="student-name" value="<?= htmlspecialchars($student['student_name'] ?? $session_name) ?>" >
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-university">Université</label>
                    <input type="text" name="student-university" id="student-university" value="<?= htmlspecialchars($student['student_university'] ?? '') ?>" >
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-field">Domaine d’études</label>
                    <select name="student-field" id="student-field" >
                        <option value="" disabled <?= empty($student['student_field']) ? 'selected' : '' ?>>-- Sélectionner --</option>
                        <option value="communication" <?= ($student['student_field'] ?? '') === 'communication' ? 'selected' : '' ?>>Communication</option>
                        <option value="law" <?= ($student['student_field'] ?? '') === 'law' ? 'selected' : '' ?>>Droit</option>
                        <option value="economics" <?= ($student['student_field'] ?? '') === 'economics' ? 'selected' : '' ?>>Économie</option>
                        <option value="management" <?= ($student['student_field'] ?? '') === 'management' ? 'selected' : '' ?>>Gestion</option>
                        <option value="computer_science" <?= ($student['student_field'] ?? '') === 'computer_science' ? 'selected' : '' ?>>Informatique</option>
                        <option value="engineering" <?= ($student['student_field'] ?? '') === 'engineering' ? 'selected' : '' ?>>Ingenierie</option>
                        <option value="medicine" <?= ($student['student_field'] ?? '') === 'medicine' ? 'selected' : '' ?>>Médecine</option>
                        <option value="social_sciences" <?= ($student['student_field'] ?? '') === 'social_sciences' ? 'selected' : '' ?>>Sciences sociales</option>
                    </select>
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-level">Niveau d’étude</label>
                    <select name="student-level" id="student-level" >
                        <option value="" disabled <?= empty($student['student_level']) ? 'selected' : '' ?>>-- Sélectionner --</option>
                        <option value="licence_1" <?= ($student['student_level'] ?? '') === 'licence_1' ? 'selected' : '' ?>>Licence 1</option>
                        <option value="licence_2" <?= ($student['student_level'] ?? '') === 'licence_2' ? 'selected' : '' ?>>Licence 2</option>
                        <option value="licence_3" <?= ($student['student_level'] ?? '') === 'licence_3' ? 'selected' : '' ?>>Licence 3</option>
                        <option value="master_1" <?= ($student['student_level'] ?? '') === 'master_1' ? 'selected' : '' ?>>Master 1</option>
                        <option value="master_2" <?= ($student['student_level'] ?? '') === 'master_2' ? 'selected' : '' ?>>Master 2</option>
                    </select>
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-phone">Téléphone</label>
                    <input type="text" name="student-phone" id="student-phone" value="<?= htmlspecialchars($student['student_phone_number'] ?? '') ?>" >
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-birthdate">Date de naissance</label>
                    <input type="date" name="student-birthdate" id="student-birthdate" value="<?= htmlspecialchars($student['student_birthdate'] ?? '') ?>" >
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-about">À propos de moi</label>
                    <textarea name="student-about" id="student-about" rows="6" cols="30"><?= htmlspecialchars($student['student_about'] ?? '') ?></textarea>
                </div>

                <div class="edit-profil-input-box">
                    <label for="student-cv">CV (PDF)</label>
                    <p class="small-note">Merci d’ajouter votre photo directement dans votre CV avant de l’importer.</p>
                    <input type="file" name="student-cv" id="student-cv" accept=".pdf, .docx" value="">
                </div>

                <button type="submit" name="edit-student-btn" class="edit-profil-btn">Modifier</button>

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
