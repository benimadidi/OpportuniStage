
<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Modifiaction du profil Entreprise */
if(isset($_POST["edit-profil-btn"])){

    $user_new_email = $_POST['user-new-email'];
    $user_new_password = password_hash($_POST['user-new-password'], PASSWORD_DEFAULT);
    $user_new_password_confirm = $_POST['user-new-password-confirm'];
    
    //Verifier si le mot de passe confirmé est le bon
    if ($_POST['user-new-password'] !== $_POST['user-new-password-confirm']) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Les mots de passe ne correspondent pas'
        ];
        $_SESSION['active-form'] = 'register';

        header('Location: ../company/edit_profil_2.php');
        exit();
    }

    //Verifier si l'utlisateur existe 
    $check_query = "SELECT user_id FROM users WHERE user_id = :user_id";
    $check = $PDO->prepare($check_query);
    $check -> bindParam(':user_id', $_SESSION['user-id'], PDO::PARAM_INT); 
    $check -> execute();

    if ($check -> rowCount() > 0){
        //Enregistrer les modifications
        $query = "UPDATE users SET
                  user_email = :user_email,
                  user_password = :user_password
                  WHERE user_id = :user_id";
        $update = $PDO->prepare($query);

        $update -> bindParam(':user_email', $user_new_email, PDO::PARAM_STR);
        $update -> bindParam(':user_password', $user_new_password, PDO::PARAM_STR);
        $update -> bindParam(':user_id', $_SESSION['user-id'], PDO::PARAM_INT);

        $update -> execute();

        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Profil modifié'
        ];
        header('Location: ../company/dashboard.php');
        exit();
    }
    
}
else{
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => "Une erreur s'est produite"
    ];
    header('Location: ../company/edit_profil_2.php');
    exit();
}

?>
