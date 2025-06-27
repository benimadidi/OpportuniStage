
<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ---------------------------------------------------------------------------------- */
/* Traitement de la modification du profil */
if(isset($_POST["edit-profil-btn"])){

    // Récupérer les données du formulaire
    $user_new_email = $_POST['user-new-email'];
    $user_new_password = password_hash($_POST['user-new-password'], PASSWORD_DEFAULT);
    $user_new_password_confirm = $_POST['user-new-password-confirm'];
    
    // Vérifier si les mots de passe correspondent
    if ($_POST['user-new-password'] !== $_POST['user-new-password-confirm']) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Les mots de passe ne correspondent pas'
        ];
        $_SESSION['active-form'] = 'register';

        header('Location: ../includes/edit_profil_2.php');
        exit();
    }

    // Vérifier si l'email est déjà utilisé par un autre utilisateur
    $query = "SELECT user_email FROM users WHERE user_email = :user_email AND user_id != :user_id";
    $check_email = $PDO->prepare($query);
    $check_email->bindParam(':user_email', $user_new_email, PDO::PARAM_STR);
    $check_email->bindParam(':user_id', $_SESSION['user-id'], PDO::PARAM_INT);
    $check_email->execute();

    if ($check_email->rowCount() > 0) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email déjà utilisé'
        ];
        header('Location: ../includes/edit_profil_2.php');
        exit();
    }

    // Vérifier si l'utilisateur existe 
    $check_query = "SELECT user_id FROM users WHERE user_id = :user_id";
    $check = $PDO->prepare($check_query);
    $check -> bindParam(':user_id', $_SESSION['user-id'], PDO::PARAM_INT); 
    $check -> execute();

    if ($check -> rowCount() > 0){
        // Mettre à jour l'email et le mot de passe
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

        // Récupérer le rôle de l'utilisateur pour redirection
        $query_role = "SELECT user_role FROM users WHERE user_id = :user_id";
        $result = $PDO -> prepare($query_role);
        $result -> bindParam(':user_id', $_SESSION['user-id'], PDO::PARAM_INT);
        $result -> execute();
        $role = $result -> fetch(PDO::FETCH_ASSOC);

        // Rediriger vers le tableau de bord approprié
        if ($role['user_role'] == 'student') {

            header('Location: ../student/dashboard.php');
            exit();
        } 
        else if ($role['user_role'] == 'company') {

            header('Location: ../company/dashboard.php');
            exit();
        }

        else {
            header('Location: ../admin/dashboard.php');
            exit();
        }
        
    }

}
/* Si le formulaire n'a pas été soumis correctement */
else{
    $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => "Une erreur s'est produite"
    ];
    // Revenir à la page précédente si possible
    $go_back = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    header("Location: $go_back");
    exit();
}

?>
