
<?php

session_start();

require_once 'db-config.php';

if(isset($_POST['register_btn'])){
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));

    $query = 'SELECT user_email FROM users WHERE user_email = :email';
    $check_email = $PDO -> prepare($query);
    $check_email -> bindParam(':email', $email, PDO::PARAM_STR);
    $check_email -> execute();

    if($check_email -> rowCount() > 0){
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email déjà utilisé'
        ];
        $_SESSION['active_form'] = 'register';
    }
    else{
        $query = "INSERT INTO users (user_name, user_email, user_password)
                   VALUES ('$name', '$email', '$password')";
        $insert = $PDO -> prepare($query);
        $insert -> execute();

        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Inscription réussie'
        ];
        $_SESSION['active_form'] = 'login';
    }

    header('Location:index.php');
    exit();
}

if(isset($_POST['login_btn'])){
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $query = 'SELECT * FROM users WHERE user_email = :email';
    $result = $PDO -> prepare($query);
    $result -> bindParam(':email', $email, PDO::PARAM_STR);
    $result -> execute();

    $user = $result -> rowCount() > 0 ? $result -> fetch(PDO::FETCH_ASSOC) : null;
    
    if ($user && password_verify($password, $user['user_password'])){
        $_SESSION['name'] = $user['user_name'];
        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Connexion réussie'
        ];
    }
    else{
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email ou mot de passe incorrect'
        ];
        $_SESSION['active_form'] = 'login';
    }

    header('Location:index.php');
    exit();
}

?>