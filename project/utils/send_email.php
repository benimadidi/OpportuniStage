<?php

use PHPMailer\PHPMailer\PHPMailer;


require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/Exception.php';

function sendApplicationEmail($to, $name, $offer, $company_name, $status) {
    $mail = new PHPMailer(true);

    // Configuration SMTP Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'opportunistage@gmail.com'; 
    $mail->Password = 'towwuxfskstkiptl';          
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('opportunistage@gmail.com', 'OpportuniStage');
    $mail->addAddress($to, $name);

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isHTML(false);
    $mail->Subject = "Statut de votre candidature sur OpportuniStage";

    if ($status === 'accepted') {
        $mail->Body = "Bonjour $name,\n\n"
            . "Nous avons le plaisir de vous informer que votre candidature pour le poste de \"$offer\" chez $company_name a bien été acceptée.\n\n"
            . "L'entreprise vous contactera très prochainement pour les prochaines étapes.\n\n"
            . "Cordialement,\nL'equipe OpportuniStage";
    } else {
        $mail->Body = "Bonjour $name,\n\n"
            . "Nous vous remercions pour l’intérêt porté à l'offre \"$offer\" chez $company_name. Après étude, votre candidature n’a pas été retenue.\n\n"
            . "Nous vous souhaitons bonne continuation dans vos recherches.\n\n"
            . "Cordialement,\nL'equipe OpportuniStage";
    }

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

    $mail->send();
    return true;


}
