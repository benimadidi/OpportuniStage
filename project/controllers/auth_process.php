<?php

/* Initialisation de la session */
session_start();

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/*-----------------------------------------------------------------------------------------*/
/* Traitement de l'inscription */
if (isset($_POST['register-btn'])) {
    // Récupérer les données du formulaire d'inscription
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $user_role = $_POST['role'];

    // Vérifier si les mots de passe correspondent
    if ($_POST['password'] !== $_POST['password-confirm']) {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Les mots de passe ne correspondent pas'
        ];
        // Pour que le formulaire inscription reste affiché après redirection
        $_SESSION['active-form'] = 'register';

        header('Location: ../index.php');
        exit();
    }

    // Vérifier si l'email est déjà utilisé
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
        // Insertion du nouvel utilisateur dans la table users
        $query = "INSERT INTO users (user_name, user_email, user_password, user_role)
                  VALUES (:user_name, :user_email, :user_password, :user_role)";
        $insert = $PDO->prepare($query);
        $insert -> bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $insert -> bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $insert -> bindParam(':user_password', $user_password, PDO::PARAM_STR);
        $insert -> bindParam(':user_role', $user_role, PDO::PARAM_STR);
        $insert -> execute();

        // Récupérer l'id nouvellement inséré
        $user_id = $PDO->lastInsertId();

        // Insérer dans la table spécifique au rôle
        if ($user_role === 'student') {
            $stmt = $PDO->prepare("INSERT INTO students (student_user_id, student_name) VALUES (:user_id, :name)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->execute();

            // Récupérer l'id specifique
            $student_id = $PDO->lastInsertId();
            $_SESSION['student-id'] = $student_id;

        } elseif ($user_role === 'company') {
            $stmt = $PDO->prepare("INSERT INTO companies (company_user_id, company_name) VALUES (:user_id, :name)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->execute();

            $company_id = $PDO->lastInsertId();
            $_SESSION['company-id'] = $company_id;
        }

        // Sauvegarder les infos dans la session
        $_SESSION['user-id'] = $user_id; 
        $_SESSION['name'] = $user_name;
        $_SESSION['role'] = $user_role;
        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Inscription réussie'
        ];
        $_SESSION['active-form'] = 'login';

        // Rediriger l'utilisateur selon son rôle
        switch ($user_role) {
            case 'student':
                header('Location: ../student/edit_profil.php');
                break;

            case 'company':
                header('Location: ../company/edit_profil.php');
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

/*-----------------------------------------------------------------------------------------*/
/* Traitement de la connexion */
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

    // Vérifier la validité du mot de passe
    if ($user_data && password_verify($user_password, $user_data['user_password'])) {
        // Charger les données spécifiques au rôle 
        switch ($user_data['user_role']) {
            case 'student':
                $sql = "SELECT student_id, student_name FROM students WHERE student_user_id = :user_id";
                $result = $PDO -> prepare($sql);
                $result -> bindParam(':user_id', $user_data['user_id'], PDO::PARAM_INT);
                $result -> execute();
                $student = $result -> fetch(PDO::FETCH_ASSOC);

                if ($student) {
                    $_SESSION['student-id'] = $student['student_id'];
                    $_SESSION['name'] = $student['student_name'];
                }

                break;

            case 'company':
                $sql = "SELECT company_id, company_name FROM companies WHERE company_user_id = :user_id";
                $result = $PDO -> prepare($sql);
                $result -> bindParam(':user_id', $user_data['user_id'], PDO::PARAM_INT);
                $result -> execute();
                $company = $result->fetch(PDO::FETCH_ASSOC);

                if ($company) {
                    $_SESSION['company-id'] = $company['company_id'];
                    $_SESSION['name'] = $company['company_name'];
                }

                break;

            case 'admin':
                $_SESSION['admin-id'] = $user_data['user_id']; 
                $_SESSION['name'] = $user_data['user_name'];
                break;
        }

         // Enregistrer l'utilisateur en session
        $_SESSION['user-id'] = $user_data['user_id'];
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
        // Si email ou mot de passe incorrect
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
