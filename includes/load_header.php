<?php

/* Gestion de l'affichage des erreurs */
error_reporting(-1);
ini_set('display_errors', 1);

/* Recuperation des variables de session */
$user_role = $_SESSION['role'] ?? '';

/* Affichage du header selon le rôle */
switch ($user_role) {
    case 'student':
        include 'header_student.php';
        break;

    case 'company':
        include 'header_company.php';
        break;

    case 'admin':
        include 'header_admin.php';
        break;

    default:
        include 'header_guests.php';
        break;
}
