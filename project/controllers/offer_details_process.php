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

// Récupération de l'ID utilisateur connecté 
$session_id = $_SESSION['user-id'] ?? null;

/*-------------------------------------------------------*/
// Récupération de l'ID de l'offre à partir de l'URL
$offer_id = $_GET['id'] ?? null;

/* Vérifier que l'ID de l'offre est fourni */
if ($offer_id) {

    /* Récupérer l'ID de l'étudiant lié à cet utilisateur */
    $query_student = "SELECT student_id FROM students WHERE student_user_id = :user_id";
    $result = $PDO->prepare($query_student);
    $result -> bindParam(':user_id', $session_id, PDO::PARAM_INT);
    $result -> execute();
    $student = $result -> fetch(PDO::FETCH_ASSOC);
}

/* Vérifier que l'étudiant existe */
if ($student) {
    $student_id = $student['student_id'];

    /* Vérifier si l'étudiant a déjà postulé à cette offre */
    $query_check = "SELECT * FROM applications WHERE application_student_id = :student_id AND application_offer_id = :offer_id";
    $result = $PDO->prepare($query_check);
    $result->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $result->bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
    $result->execute();

    /* Si candidature déjà existante, alerte et redirection */
    if ($result -> rowCount() > 0) {
        $_SESSION['alerts'][] = [
            'type' => 'error', 
            'message' => 'Vous avez déjà postulé à cette offre'
        ];
        header("Location: ../student/offers.php?id=" . $offer_id);
        exit;
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
}

/* Si pas d'ID d'offre ou pas d'étudiant trouvé */
$_SESSION['alerts'][] = [
    'type' => 'error',
    'message' => "Impossible de postuler : informations manquantes"
];
header("Location: ../student/offers.php");
exit;


?>
