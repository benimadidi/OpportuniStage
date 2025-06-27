<?php

// Importation de la classe PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

// Inclusion des fichiers nécessaires de PHPMailer
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/Exception.php';

function sendApplicationEmail($to, $name, $offer, $company_name, $status) {
    // Créer une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true);

    // Configuration SMTP Gmail
    $mail->isSMTP();                                     // Utiliser SMTP
    $mail->Host = 'smtp.gmail.com';                      // Serveur SMTP de Gmail
    $mail->SMTPAuth = true;                              // Activer l'authentification
    $mail->Username = 'opportunistage@gmail.com';        // Email d'envoi
    $mail->Password = 'towwuxfskstkiptl';                // Mot de passe d'application Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Chiffrement TLS
    $mail->Port = 587;                                   // Port SMTP

    // Définir l'expéditeur et le destinataire
    $mail -> setFrom('opportunistage@gmail.com', 'OpportuniStage');
    $mail -> addAddress($to, $name);

    // Définir l'expéditeur et le destinataire
    $mail -> CharSet = 'UTF-8';
    $mail -> Encoding = 'base64';
    $mail -> isHTML(false);

    // Sujet de l'email
    $mail -> Subject = "Statut de votre candidature sur OpportuniStage";

    // Contenu du message selon le statut
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

    // Options SSL supplémentaires
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    // Envoi de l'email
    $mail->send();
    return true;


}
