<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Inclure le fichier de configuration
require_once '../config/db-config.php';

// Récuperer les donnees de session
$session_id = $_SESSION['user-id'] ?? null;

/*-------------------------------------------------------*/
// Recuperation de l'id de l'offre
$offer_id = $_GET['id'] ?? null;

if ($offer_id) {

    // Récupérer l'étudiant lie a ce user_id
    $query_student = "SELECT student_id FROM students WHERE student_user_id = :user_id";
    $result = $PDO->prepare($query_student);
    $result -> bindParam(':user_id', $session_id, PDO::PARAM_INT);
    $result -> execute();
    $student = $result -> fetch(PDO::FETCH_ASSOC);
}

if ($student) {
    $student_id = $student['student_id'];

    // Verifier si l'etudiant a deja postuler a cette offre
    $query_check = "SELECT * FROM applications WHERE application_student_id = :student_id AND application_offer_id = :offer_id";
    $result = $PDO->prepare($query_check);
    $result->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $result->bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
    $result->execute();

    if ($result -> rowCount() > 0) {
        $_SESSION['alerts'][] = [
            'type' => 'error', 
            'message' => 'Vous avez déjà postulé à cette offre'
        ];
        header("Location: ../student/offers.php?id=" . $offer_id);
        exit;
    }
}

// Enregistrer la candidature
$query_insert = "INSERT INTO applications (application_student_id, application_offer_id) VALUES (:student_id, :offer_id)";
$result = $PDO -> prepare($query_insert);
$result -> bindParam(':student_id', $student_id, PDO::PARAM_INT);
$result -> bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
$result -> execute();

$_SESSION['alerts'][] = [
    'type' => 'success', 
    'message' => 'Votre candidature a bien été envoyée'
];

header("Location: ../student/offers.php?id=" . $offer_id);
exit;

?>
