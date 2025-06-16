
<?php

/* Initialisation de la session */
session_start();
var_dump($_SESSION['user-id']);

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Modifiaction du profil Entreprise */
if(isset($_POST["edit-profil-btn"])){
    
    $company_name = htmlspecialchars($_POST['company-name']);
    $company_tel = htmlspecialchars($_POST['company-tel'] ?? '');
    $company_sector = $_POST['company-sector'] ?? '';
    $company_size = $_POST['company-size'] ?? '';
    $company_description = htmlspecialchars($_POST['company-description'] ?? '');
    $company_website = htmlspecialchars($_POST['company-website'] ?? '');
    $company_address = htmlspecialchars($_POST['company-address'] ?? '');

    //Enregistrements des donnees
    $query = "INSERT INTO companies (
                company_user_id,
                company_name, 
                company_phone_number, 
                company_sector, 
                company_size, 
                company_description, 
                company_website, 
                company_address
              )
              VALUES (
                :company_user_id,
                :company_name, 
                :company_phone_number, 
                :company_sector, 
                :company_size, 
                :company_description, 
                :company_website, 
                :company_address
              )";

    $update = $PDO->prepare($query);
    $update->bindParam(':company_user_id', $_SESSION['user-id'], PDO::PARAM_INT);
    $update->bindParam(':company_name', $company_name, PDO::PARAM_STR);
    $update->bindParam(':company_phone_number', $company_tel, PDO::PARAM_STR);
    $update->bindParam(':company_sector', $company_sector, PDO::PARAM_STR);
    $update->bindParam(':company_size', $company_size, PDO::PARAM_STR);
    $update->bindParam(':company_description', $company_description, PDO::PARAM_STR);
    $update->bindParam(':company_website', $company_website, PDO::PARAM_STR);
    $update->bindParam(':company_address', $company_address, PDO::PARAM_STR);
    $update->execute();

    //Enregistrer les donnees utilisateur dans la session
    $_SESSION['company-tel'] = $company_tel;
    $_SESSION['company-sector'] = $company_sector;
    $_SESSION['company-size'] = $company_size;
    $_SESSION['company-description'] = $company_description;
    $_SESSION['company-website'] = $company_website;
    $_SESSION['company-address'] = $company_address;
    $_SESSION['alerts'][] = [
        'type' => 'success',
        'message' => 'Profil modifié'
    ];
    header('Location: ../company/dashboard.php');
    exit();

     
}
else{
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => "Profil une erreur s'est produite"
    ];
    header('Location: ../company/dashboard.php');
    exit();
}

?>
