
<?php	

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Recuperation de l'id de l'offre
$user_id = $_GET['id'] ?? null;

//Suppression de l'offre
if ($user_id){
    require_once '../config/db-config.php';

    //Requête pour supprimer l'offre
    $query = "DELETE FROM users WHERE user_id = :user_id";
    $result = $PDO -> prepare($query);
    $result -> bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $result -> execute();
}

$_SESSION['alerts'][] = [
    'type' => 'success',
    'message' => 'Utilisateur supprimé'
];

header('Location: view_user.php');
exit;

?>