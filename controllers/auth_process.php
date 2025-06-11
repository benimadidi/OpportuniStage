
<?php

error_reporting(-1);
ini_set('display_errors', 1);

session_start();

require_once './config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Inscription */
if(isset($_POST['register-btn'])){
    $user_name = htmlspecialchars($_POST['name']);
    $user_email = htmlspecialchars($_POST['email']);
    $user_password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));
    $role = htmlspecialchars($_POST['role']);

    /*Verifier s'il existe deja un email*/
    $query = "";
    $check_email = $PDO -> prepare($query);
    $check_email -> bindParam(':user_email', $user_email, PDO::PARAM_STR );
    $check_email -> execute();

    if ($check_email -> rowCount() > 0){
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Email déjà utilisé'
        ];
        $_SESSION['active-form'] = 'register';
    }
    else{
        /*enregistrement de l'utilisateur*/ 
        $query = "";
        $insert = $PDO -> prepare($query);
        $insert -> execute();

        $_SESSION['alertts'][] = [
            'type' => 'success',
            'message' => 'Inscription réussie'
        ];
        $_SESSION['active-form'] = 'login';
    }

    header('Location:index.php');
    exit();
        
}

if (isset($_POST['login-btn'])){
    $user_email = htmlspecialchars($_POST['email']);
    $user_password = htmlspecialchars($_POST['password']);

    $query = "";
    $check_email = $PDO -> prepare($query);
    $check_email -> bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $check_email -> execute();

    if ($check_email -> rowCount() > 0)
        $user_connect= $check_email -> fetch(PDO::FETCH_ASSOC);
    else
        $user_connect = null;
                                                      /*Voir base de donnees*/
    if ( $user && password_verify($user_password, $user_connect[''])){
                                        /*Voir base de donnees*/
        $_SESSION['name'] = $user_connect[''];
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
        $_SESSION['active-form'] = 'login';
    }

    header('Location:index.php');
    exit();

} 

?>