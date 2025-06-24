<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



function sendApplicationEmail($mail, $to, $content) {
    //Create an instance; passing `true` enables exceptions

    $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'opportunistage@gmail.com';                     //SMTP username
    $mail->Password   = 'towwuxfskstkiptl';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('opportunistage@gmail.com', 'OpportuniStage');
    $mail->addAddress($to, 'User');     //Add a recipient
    //Content
    $mail->isHTML(false);                                  //Set email format to HTML
    $mail->Subject = "Statut de votre candidature sur OpportuniStage";
    $mail->Body    = 'This is the HTML message body ' . $content ;

    $mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
];

    $mail->send();
    echo 'Message has been sent';

}