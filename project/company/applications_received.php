
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

/*-------------------------------------------------------*/
// Initialisation de la session
session_start();

/*-------------------------------------------------------*/
// Inclure le fichier de configuration
require_once '../config/db-config.php';

/*-------------------------------------------------------*/
// Recuperer l'id de l'entreprise
$company_id = intval($_GET['company_id']) ?? null;


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
    <meta charset="UTF-8" />
    <title>Candidatures reçues</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>

<h2>Candidatures reçues</h2>

<?php if (count($applications) > 0): ?>
<table>
    <thead>
        <tr>
            <th>Étudiant</th>
            <th>Offre</th>
            <th>Statut</th>
            <th>Date de candidature</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($applications as $app): ?>
        <tr>
            <td><a href="../student/profil.php?id=<?php echo $app['student_user_id'] ?>"><?php echo htmlspecialchars($app['student_name']); ?></a></td>
            <td><?php echo htmlspecialchars($app['offer_title']); ?></td>
            <td><?php echo htmlspecialchars($app['application_status']); ?></td>
            <td><?php echo htmlspecialchars($app['application_created_at']); ?></td>
            <td>

                <form action="../controllers/applications_process.php" method="POST" style="display:inline">
                    <input type="hidden" name="id" value="<?php echo $app['application_id'] ?>">
                    <input type="hidden" name="action" value="accepted">
                    <button type="submit" class="btn-success">Accepter</button>
                </form>

                <form action="../controllers/applications_process.php" method="POST" style="display:inline">
                    <input type="hidden" name="id" value="<?php echo $app['application_id'] ?>">
                    <input type="hidden" name="action" value="refused">
                    <button type="submit" class="btn-danger">Rejeter</button>
                </form>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
<p>Aucune candidature reçue pour le moment.</p>
<?php endif; ?>

</body>
</html>
