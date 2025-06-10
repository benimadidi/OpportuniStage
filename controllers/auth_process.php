
<?php

session_start();

require_once './config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Inscription */
if(isset($_POST['register-btn'])){
    $user_name = htmlspecialchars($_POST['name']);
    $user_email = htmlspecialchars($_POST['email']);
    $user_password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));

}
