
<?php 

/*------------------------------------------------------------*/
/*Fonction de formatage des dates*/
function dateFormat($date){
    if (!empty($date)){
    $date_format = new DateTime($date);
    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Africa/Kinshasa',
        IntlDateFormatter::GREGORIAN,
        'd MMMM yyyy'
    );
    $date_fr = $formatter->format($date_format);

    return $date_fr;
}
}

?>