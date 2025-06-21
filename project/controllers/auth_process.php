<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Inscription */
if (isset($_POST['register-btn'])) {
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $user_role = $_POST['role'];

    //Verifier si le mot de passe confirmé est le bon
    if ($_POST['password'] !== $_POST['password-confirm']) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Les mots de passe ne correspondent pas'
        ];
        $_SESSION['active-form'] = 'register';

        header('Location: ../index.php');
        exit();
    }

    // Vérifier si l'email existe déjà                      test avec une petite bd
    $query = "SELECT user_email FROM users WHERE user_email = :user_email";
    $check_email = $PDO->prepare($query);
    $check_email -> bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $check_email -> execute();

    // Si l'email existe, afficher un message d'erreur
    if ($check_email -> rowCount() > 0) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email déjà utilisé'
        ];
        $_SESSION['active-form'] = 'register';

        header('Location: ../index.php');
        exit();

    } else {
        // Enregistrement utilisateur              test avec une petite bd
        $query = "INSERT INTO users (user_name, user_email, user_password, user_role)
                  VALUES (:user_name, :user_email, :user_password, :user_role)";
        $insert = $PDO->prepare($query);
                        // test
        $insert->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $insert->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $insert->bindParam(':user_password', $user_password, PDO::PARAM_STR);
        $insert->bindParam(':user_role', $user_role, PDO::PARAM_STR);
        $insert->execute();

        //Enregistrer l'utilisateur dans la session
        $_SESSION['user-id'] = $PDO->lastInsertId(); 
        $_SESSION['name'] = $user_name;
        $_SESSION['role'] = $user_role;
        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Inscription réussie'
        ];
        $_SESSION['active-form'] = 'login';

        // Redirection selon rôle
        switch ($user_role) {
            case 'student':
                header('Location: ../student/dashboard.php');
                break;

            case 'company':
                header('Location: ../company/dashboard.php');
                break;

            case 'admin':
                header('Location: ../admin/dashboard.php');
                break;

            default:
                header('Location: ../index.php');
                break;
        }
        exit();
    }
}

/* ///////////////////////////////////////////////////// */
/* Connexion */
if (isset($_POST['login-btn'])) {
    $user_email = htmlspecialchars($_POST['email']);
    $user_password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $query = "SELECT * FROM users WHERE user_email = :user_email";
    $check_email = $PDO->prepare($query);
    $check_email->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $check_email->execute();

    // Récupérer les données de l'utilisateur
    if ($check_email-> rowCount() > 0) {
        $user_data = $check_email -> fetch(PDO::FETCH_ASSOC);
    } else {
        $user_data = null;
    }

    // Vérifier si le mot de passe est correct
    if ($user_data && password_verify($user_password, $user_data['user_password'])) {
        $_SESSION['user-id'] = $user_data['user_id'];
        $_SESSION['name'] = $user_data['user_name'];
        $_SESSION['role'] = $user_data['user_role'];
        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Connexion réussie'
        ];

        // Redirection selon rôle
        switch ($user_data['user_role']) {
            case 'student':
                header('Location: ../student/dashboard.php');
                break;

            case 'company':
                header('Location: ../company/dashboard.php');
                break;

            case 'admin':
                header('Location: ../admin/dashboard.php');
                break;

            default:
                header('Location: ../index.php');
                break;
        }
        exit();

    } else {
        // Afficher un message d'erreur si l'email ou le mot de passe est incorrect
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email ou mot de passe incorrect'
        ];
        $_SESSION['active-form'] = 'login';

        header('Location: ../index.php');
        exit();
    }
}

?>
