
<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Ajout d'une offre */
if (isset($_POST['add-offer-btn'])){

    $offer_title = $_POST['offer-title'];
    $offer_description = $_POST['offer-description'];
    $offer_location = $_POST['offer-location'];
    $offer_sector = $_POST['offer-sector'];
    $offer_type = $_POST['offer-type'];
    $offer_duration = $_POST['offer-duration'];
    $offer_deadline = $_POST['offer-deadline'];
    $offer_profile = $_POST['offer-profile'];
    $offer_remuneration = $_POST['offer-remuneration'];

    //Recuperer le company-id lié a l'utilisateur connecté
    $query_company = "SELECT company_id FROM companies WHERE company_user_id = :company_user_id";
    $result = $PDO -> prepare($query_company);
    $result -> bindParam(":company_user_id", $_SESSION['user-id'], PDO::PARAM_INT);
    $result -> execute();

    $company_id = $result -> fetch(PDO::FETCH_ASSOC);
    $company_id = $company_id['company_id'];

    //Enregistrer les données de l'utilisateur
    $query = "INSERT INTO offers (
                offer_company_id,
                offer_title, 
                offer_description, 
                offer_location, 
                offer_sector, 
                offer_type, 
                offer_duration, 
                offer_deadline, 
                offer_profile, 
                offer_remuneration
            )
            VALUES (
                :offer_company_id,
                :offer_title, 
                :offer_description, 
                :offer_location, 
                :offer_sector, 
                :offer_type, 
                :offer_duration, 
                :offer_deadline, 
                :offer_profile, 
                :offer_remuneration
            )";

    $insert = $PDO->prepare($query);

    $insert -> bindParam(':offer_company_id', $company_id, PDO::PARAM_INT);
    $insert -> bindParam(':offer_title', $offer_title, PDO::PARAM_STR);
    $insert -> bindParam(':offer_description', $offer_description, PDO::PARAM_STR);
    $insert -> bindParam(':offer_location', $offer_location, PDO::PARAM_STR);
    $insert -> bindParam(':offer_sector', $offer_sector, PDO::PARAM_STR);
    $insert -> bindParam(':offer_type', $offer_type, PDO::PARAM_STR);
    $insert -> bindParam(':offer_duration', $offer_duration, PDO::PARAM_INT);
    $insert -> bindParam(':offer_deadline', $offer_deadline, PDO::PARAM_STR);
    $insert -> bindParam(':offer_profile', $offer_profile, PDO::PARAM_STR);
    $insert -> bindParam(':offer_remuneration', $offer_remuneration, PDO::PARAM_STR);

    $insert -> execute();

    //Enregistrer les donnees utilisateur dans la session
    $_SESSION['alerts'][] = [
        'type' => 'success',
        'message' => 'Offre Publiée avec succès'
    ];
    
    header('Location: ../company/dashboard.php');
    exit();

}

else{
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => "Une erreur s'est produite"
    ];
    header('Location: ../company/dashboard.php');
    exit();
}

?>
