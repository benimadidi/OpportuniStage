
<?php

/* Inclusion des fichiers de configuration */
require_once '../config/db-config.php';

/* ///////////////////////////////////////////////////// */
/* Initialisation des variables */
$user_id = $_SESSION['user-id'];
$offers  = [];

//Récupérer les offres
if ($user_id){
    $sql = "SELECT * FROM  offers WHERE offer_company_id = (
                SELECT company_id FROM companies WHERE company_user_id = :company_user_id
            )";
    $result = $PDO -> prepare($sql);
    $result -> bindParam(':company_user_id', $user_id, PDO::PARAM_INT);
    $result -> execute();
    $offers = $result -> fetchAll(PDO::FETCH_ASSOC);
}

//Stocker les offres dans la session
$_SESSION['offers'] = $offers;
