
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(0);
ini_set('display_errors', 0);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Inclure le fichier de configuration
require_once '../config/db-config.php';

/*-------------------------------------------------------*/
// Recuperer l'id de l'entreprise
$company_id = $_GET['company_id'] ?? null;


//recuperer les candidatures recues
$query_get_apps = "SELECT applications.*, students.student_name, students.student_user_id ,offers.offer_title
                  FROM applications
                  JOIN students ON students.student_id = applications.application_student_id
                  JOIN offers ON offers.offer_id = applications.application_offer_id
                  WHERE offers.offer_company_id = :company_id AND application_status NOT IN ('accepted', 'refused')
                  ORDER BY applications.application_created_at DESC";
$result_get_apps = $PDO -> prepare($query_get_apps);
$result_get_apps -> bindParam(":company_id", $company_id, PDO::PARAM_INT);
$result_get_apps -> execute();
$applications = $result_get_apps -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

    <head>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Métadonnées de la page -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpportuniSatge</title>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!--styles -->
        <link rel="stylesheet" href="../assets/css/style.css">

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!--Icones-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Inclusion des alertes -->
        <?php include '../includes/alerts.php' ?>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Section affichant les candidatures reçues -->
        <section class="application-received">


            <h2>Candidature<?php if(count($applications) > 1) echo 's'; ?> reçue<?php if(count($applications) > 1) echo 's'; ?></h2>

            <?php if (count($applications) > 0): ?>

            <div class="application-table">

                <table>

                    <thead>

                        <tr>

                            <th>Étudiant</th>
                            <th>Offre</th>
                            <th>Date de candidature</th>
                            <th>Actions</th>

                        </tr>

                    </thead>
                    
                    <tbody>

                        <?php foreach($applications as $app): ?>

                            <!-- Formater la date en francais -->
                            <?php
                                if (!empty($app['application_created_at'])){
                                    $date_format = new DateTime($app['application_created_at']);
                                    $formatter = new IntlDateFormatter(
                                        'fr_FR',
                                        IntlDateFormatter::LONG,
                                        IntlDateFormatter::NONE,
                                        'Africa/Kinshasa',
                                        IntlDateFormatter::GREGORIAN,
                                        'd MMMM yyyy'
                                    );
                                    $date_fr = $formatter->format($date_format);
                                }
                            ?>

                        <tr>
                            <td><a href="../student/profil.php?id=<?php echo $app['student_user_id'] ?>"><?php echo htmlspecialchars($app['student_name']); ?></a></td>
                            <td><?php echo htmlspecialchars($app['offer_title']); ?></td>
                            <td>Le <?php echo htmlspecialchars($date_fr); ?></td>
                            <td>

                                <div class="action">
                                    
                                    <!-- Formulaire d'acceptation -->
                                    <form action="../controllers/applications_process.php" method="POST" style="display:inline">
                                        <input type="hidden" name="id" value="<?php echo $app['application_id'] ?>">
                                        <input type="hidden" name="action" value="accepted">
                                        <button type="submit" class="btn-action btn-success">Accepter</button>
                                    </form>

                                    <!-- Formulaire de refus avec bouton déclenchant la confirmation -->
                                    <form action="../controllers/applications_process.php" method="POST" class="reject-form" style="display:inline">
                                        <input type="hidden" name="id" value="<?php echo $app['application_id'] ?>">
                                        <input type="hidden" name="action" value="refused">
                                        <button type="button" class="btn-action reject-btn">Rejeter</button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <?php else: ?>
                <p>Aucune candidature reçue pour le moment.</p>
            <?php endif; ?>

        </section>

        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Boîte de confirmation pour rejeter -->
        <div id="confirm-modal" class="modal-overlay">

            <div class="modal-content">

                <h4>Confirmer l'action</h4>

                <p>Êtes-vous sûr de vouloir rejeter cette candidature ?</p>

                <div class="modal-buttons">
                    <button id="confirm-yes" class="reject">Oui, rejeter</button>
                    <button id="confirm-no" class="cancel">Annuler</button>
                </div>
                
            </div>

        </div>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Bibliothèque ScrollReveal pour animations au scroll -->
        <script src="https://unpkg.com/scrollreveal"></script>


        <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                    <!-- Script -->
        <script src="../assets/js/script.js"></script>

    </body>

</html>