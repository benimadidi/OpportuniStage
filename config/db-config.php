
<?php

/* Parametres de connexion a la base */
$DSN = 'mysql:host=localhost;dbname=OpportuniSatge';
$DB_USER = 'root';
$DB_PASS = '';
$options =[
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
];

/* Connexion a la base */
try{

    $PDO = new PDO($DSN, $DB_USER, $DB_PASS, $options);
}
catch(PDOException $pe){
    echo 'Erreur' . $pe -> getMessage();
}
