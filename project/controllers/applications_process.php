
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


//Recuperer l'id et la valeur de la candidature
$application_id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;

$new_status =  ($action === 'accepted') ? 'accepted' : 'refused';

/*-------------------------------------------------------*/
//Recuperer les infos de l'etudiant
$get_student_info = "SELECT users.user_email AS student_email, students.student_name, offers.offer_title, companies.company_name, users.user_email AS company_email, companies.company_phone_number 
                     FROM applications
                     JOIN students ON students.student_id = applications.application_student_id
                     JOIN users ON users.user_id = students.student_user_id
                     JOIN offers ON offers.offer_id = applications.application_offer_id
                     JOIN companies ON companies.company_id = offers.offer_company_id
                     WHERE applications.application_id = :application_id";
$result = $PDO -> prepare($get_student_info);
$result -> bindParam(':application_id', $application_id, PDO::PARAM_INT);
$result -> execute();
$info = $result -> fetch(PDO::FETCH_ASSOC);

/*-------------------------------------------------------*/
// Mettre à jour la candidature
$query = "UPDATE applications SET application_status = :new_status WHERE application_id = :application_id";
$result = $PDO -> prepare($query);
$result -> bindParam(':new_status', $new_status, PDO::PARAM_STR);
$result -> bindParam(':application_id', $application_id, PDO::PARAM_INT);
$result -> execute();

/*-------------------------------------------------------*/
//Envoyer un email de confirmation à l'etudiant
$mail_to = $info['student_email'] ?? null;
$subject = "Status de votre Candidature sur Opportunistage";
$offer = $info['offer_title'] ?? "l'offre";
$student_name = $info['student_name'] ?? 'candidat';
$company_name = $info['company_name'] ?? "l'entreprise";

/*-------------------------------------------------------*/
//Envoyer l'email si l'addresse de l'etudiant existe
require_once '../utils/send_email.php';

if ($mail_to){
    if (sendApplicationEmail($mail_to, $student_name, $offer, $company_name, $new_status)) {
        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => "La candidature a été " . ($action === 'accepted' ? 'acceptée' : 'refusée') . "<br>Un email a été envoyé au candidat"
        ];
    } else {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => "La candidature a été mise à jour, mais l'email n'a pas pu être envoyé"
        ];
    }
} else {
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => "La candidature a été mise à jour<br>, mais l'adresse email du candidat est manquante"
    ];
}

header('Location: ../company/dashboard.php');
exit;
