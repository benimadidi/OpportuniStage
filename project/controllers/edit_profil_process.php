
<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/*Recuperer l'id de l'utilisateur */
$user_id = $_SESSION['user-id'] ?? null;

/* ///////////////////////////////////////////////////// */
/* Modifiaction du profil Entreprise */
if(isset($_POST["edit-profil-btn"])){
    
    $company_name = !empty($_POST['company-name']) ? $_POST['company-name'] : null;
    $company_tel = !empty($_POST['company-tel']) ? $_POST['company-tel'] : null;
    $company_sector = !empty($_POST['company-sector']) ? $_POST['company-sector'] : null;
    $company_size = !empty($_POST['company-size']) ? $_POST['company-size'] : null;
    $company_description = !empty($_POST['company-description']) ? $_POST['company-description'] : null;
    $company_website = !empty($_POST['company-website']) ? $_POST['company-website'] : null;
    $company_address = !empty($_POST['company-address']) ? $_POST['company-address'] : null;

    //Verifier si la societe existe deja 
    $check_query = "SELECT company_id FROM companies WHERE company_user_id = :company_user_id";
    $check = $PDO->prepare($check_query);
    $check -> bindParam(':company_user_id', $user_id, PDO::PARAM_INT); 
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

    $update->bindParam(':company_user_id', $user_id, PDO::PARAM_INT);
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

/*//////////////////////////////////////////////////////*/
/* Modification du profil étudiant */
if (isset($_POST["edit-student-btn"])) {

    $student_name = !empty($_POST['student-name']) ? $_POST['student-name'] : null;
    $student_university = !empty($_POST['student-university']) ? $_POST['student-university'] : null;
    $student_field = !empty($_POST['student-field']) ? $_POST['student-field'] : null;
    $student_level = !empty($_POST['student-level']) ? $_POST['student-level'] : null;
    $student_phone = !empty($_POST['student-phone']) ? $_POST['student-phone'] : null;
    $student_birthdate = !empty($_POST['student-birthdate']) ? $_POST['student-birthdate'] : null;
    $student_about = !empty($_POST['student-about']) ? $_POST['student-about'] : null;

    //verifier si le cv a ete charge
    $student_cv_path = null;
    if (!empty($_FILES['student-cv']['name'])) {
        $upload_dir = '../uploads/cvs/';
        $file_name = basename($_FILES['student-cv']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Vérifier l'extension du fichier
        if (in_array($file_ext, ['pdf', 'docx'])) {
            $new_file_name = uniqid('cv_') . '.' . $file_ext;
            $final_path = $upload_dir . $new_file_name;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Enregistrer le fichier
            if (move_uploaded_file($_FILES['student-cv']['tmp_name'], $final_path)) {
                $student_cv_path = $final_path ;
            }
        }
    }

    // Vérifier si l'étudiant existe
    $check_query = "SELECT student_id FROM students WHERE student_user_id = :user_id";
    $check = $PDO->prepare($check_query);
    $check->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $check->execute();

    if ($check -> rowCount() > 0) {
        // Étudiant existe : UPDATE
        $query = "UPDATE students SET
                    student_name = :student_name,
                    student_university = :student_university,
                    student_field = :student_field,
                    student_level = :student_level,
                    student_phone_number = :student_phone_number,
                    student_birthdate = :student_birthdate,
                    student_about = :student_about"
                    . ($student_cv_path ? ", student_cv = :student_cv" : "") . "
                  WHERE student_user_id = :user_id";
    } else {
        // Étudiant n'existe pas : INSERT
        $query = "INSERT INTO students (
                    student_user_id, student_name, student_university, student_field,
                    student_level, student_phone_number, student_birthdate, student_about"
                    . ($student_cv_path ? ", student_cv" : "") . "
                  ) VALUES (
                    :user_id, :student_name, :student_university, :student_field,
                    :student_level, :student_phone_number, :student_birthdate, :student_about"
                    . ($student_cv_path ? ", :student_cv" : "") . ")";
    }

    $result = $PDO->prepare($query);

    $result ->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $result ->bindParam(':student_name', $student_name, PDO::PARAM_STR);
    $result ->bindParam(':student_university', $student_university, PDO::PARAM_STR);
    $result ->bindParam(':student_field', $student_field, PDO::PARAM_STR);
    $result ->bindParam(':student_level', $student_level, PDO::PARAM_STR);
    $result ->bindParam(':student_phone_number', $student_phone, PDO::PARAM_STR);
    $result ->bindParam(':student_birthdate', $student_birthdate, PDO::PARAM_STR);
    $result ->bindParam(':student_about', $student_about, PDO::PARAM_STR);

    if ($student_cv_path) {
        $result ->bindParam(':student_cv', $student_cv_path, PDO::PARAM_STR);
    }

    $result -> execute();

    $_SESSION['alerts'][] = [
        'type' => 'success',
        'message' => 'Profil étudiant mis à jour'
    ];

    header('Location: ../student/dashboard.php');
    exit();
}


else{
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => "Une erreur s'est produite"
    ];
    $go_back = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    header("Location: $go_back");
    exit();
}

?>
