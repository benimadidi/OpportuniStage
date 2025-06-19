
<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Modifiaction du profil Entreprise */
if(isset($_POST["edit-profil-btn"])){
    
    $company_name = !empty($_POST['company-name']) ? $_POST['company-name'] : ( $_SESSION['name'] ?? null);
    $company_tel = !empty($_POST['company-tel']) ? $_POST['company-tel'] : null;
    $company_sector = !empty($_POST['company-sector']) ? $_POST['company-sector'] : null;
    $company_size = !empty($_POST['company-size']) ? $_POST['company-size'] : null;
    $company_description = !empty($_POST['company-description']) ? $_POST['company-description'] : null;
    $company_website = !empty($_POST['company-website']) ? $_POST['company-website'] : null;
    $company_address = !empty($_POST['company-address']) ? $_POST['company-address'] : null;

    //Verifier si la societe existe deja 
    $check_query = "SELECT company_id FROM companies WHERE company_user_id = :company_user_id";
    $check = $PDO->prepare($check_query);
    $check -> bindParam(':company_user_id', $_SESSION['user-id'], PDO::PARAM_INT); 
    $check -> execute();

    if ($check -> rowCount() > 0){
        // Elle existe : on fait un UPDATE
        $query = "UPDATE companies SET
                  company_name = :company_name,
                  company_phone_number = :company_phone_number,
                  company_sector = :company_sector,
                  company_size = :company_size,
                  company_description = :company_description,
                  company_website = :company_website,
                  company_address = :company_address
        WHERE company_user_id = :company_user_id";
    }
    else{
        // Elle n'existe pas : on fait un INSERT
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
    }

    $update = $PDO->prepare($query);

    $update->bindParam(':company_user_id', $_SESSION['user-id'], PDO::PARAM_INT);
    $update->bindParam(':company_name', $company_name, PDO::PARAM_STR);
    $update->bindParam(':company_phone_number', $company_tel, $company_tel === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $update->bindParam(':company_sector', $company_sector, $company_sector === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $update->bindParam(':company_size', $company_size, PDO::PARAM_STR);
    $update->bindParam(':company_description', $company_description, $company_description === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $update->bindParam(':company_website', $company_website, $company_website === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $update->bindParam(':company_address', $company_address, $company_address === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

    $update->execute();

    //Enregistrer les donnees utilisateur dans la session
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
        'message' => "Une erreur s'est produite"
    ];
    header('Location: ../company/dashboard.php');
    exit();
}

?>
