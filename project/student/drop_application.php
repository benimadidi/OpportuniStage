
<?php	

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(0);
ini_set('display_errors', 0);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

//Recuperer l'id de l'etudiant
$student_id = $_SESSION['student-id'] ?? null;

/*-------------------------------------------------------*/
// Recuperation de l'id de la candidature
$application_id = $_GET['id'] ?? null;

if ($student_id && $application_id){
    require_once '../config/db-config.php';

    //Verifier si la candidature existe et si elle appartient a l'etudiant
    $sql = "SELECT * FROM applications WHERE application_id = :application_id AND application_student_id = :student_id";
    $result = $PDO -> prepare($sql);
    $result -> bindParam(":application_id", $application_id, PDO::PARAM_INT);
    $result -> bindParam(":student_id", $student_id, PDO::PARAM_INT);
    $result -> execute();
    $application = $result -> fetch(PDO::FETCH_ASSOC);

    if ($application){
        //Suppression de la candidature
        $sql = "DELETE FROM applications WHERE application_id = :application_id";
        $result = $PDO -> prepare($sql);
        $result -> bindParam(":application_id", $application_id, PDO::PARAM_INT);
        $result -> execute();

        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Candidature supprimée'
        ];
    }
    else{
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Candidature introuvable'
        ]; 

    }
}

//Redirection vers la page des candidatures
header('Location: my_applications.php');
exit();

?>