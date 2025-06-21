
<?php

$DSN = 'mysql:host=localhost;dbname=user_db';
$USER = 'root';
$PASS = '';

$options =[
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {

    $PDO = new PDO($DSN, $USER, $PASS, $options);
}
catch(PDOException $pe){
    echo $pe -> getMessage();
}