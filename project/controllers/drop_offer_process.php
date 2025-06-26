
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
$offer_id = $_GET['id'] ?? null;

if ($offer_id){
    require_once '../config/db-config.php';

        //Suppression de l'offre
    $sql = "DELETE FROM offers WHERE offer_id = :offer_id";
    $result = $PDO -> prepare($sql);
    $result -> bindParam(":offer_id", $offer_id, PDO::PARAM_INT);
    $result -> execute();

    $_SESSION['alerts'][] = [
        'type' => 'success',
        'message' => 'Offre supprimée'
    ];
}

else{
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => 'Offre introuvable'
    ];
}

//Redirection vers la page des offres
header('Location: ../admin/offers.php');
exit;

?>
