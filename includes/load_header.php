
<?php

error_reporting(-1);
ini_set('display_errors', 1);

$role = $_SESSION['role'] ?? '';

switch ($role) {
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

?>