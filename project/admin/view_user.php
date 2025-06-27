
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
// Recuperation des variables de session
$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$session_id = $_SESSION['user-id'] ?? null;


/*-------------------------------------------------------*/
// Suppression des variables d'alerts
unset($_SESSION['alerts']);

/*-------------------------------------------------------*/
//Recuperer le nom de l'admin
$query_admin = "SELECT user_name FROM users WHERE user_id = :user_id";
$result = $PDO -> prepare($query_admin);
$result -> bindParam(":user_id", $session_id, PDO::PARAM_INT);
$result -> execute();
$admin = $result -> fetch(PDO::FETCH_ASSOC);

/*-------------------------------------------------------*/
// Requete pour recuperer les utilisateurs 
$query = "SELECT 
          students.student_user_id AS id,
          students.student_name AS name,
          users.user_email AS email,
          users.user_role AS role,
          students.student_created_at AS created_at
          FROM students 
          JOIN users ON users.user_id = students.student_user_id
          
          UNION ALL
          
          SELECT 
              companies.company_user_id AS id,
              companies.company_name AS name,
              users.user_email AS email,
              users.user_role AS role,
              companies.company_created_at AS created_at
          FROM companies
          JOIN users ON users.user_id = companies.company_user_id
          ORDER BY id";
$result = $PDO -> prepare($query);
$result -> execute();
$users = $result -> fetchAll(PDO::FETCH_ASSOC);

// var_dump($users);
// exit;

?>

<!DOCTYPE html>
<html lang="fr">

    <head>

        <!--////////////////////////////////////////////////////-->
                    <!--Les metas données-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpportuniSatge</title>

        <!--////////////////////////////////////////////////////-->
                    <!--styles -->
        <link rel="stylesheet" href="../assets/css/style.css">

        <!--////////////////////////////////////////////////////-->
                    <!--Icons-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

        <!--////////////////////////////////////////////////////-->
                    <!--alerts-->
        <?php include '../includes/alerts.php' ?>


        <!--////////////////////////////////////////////////////-->
                    <!-- Header de l'admin -->
        <header class="header">

            <a href="#" class="logo">OpportuniSatge</a>

            <i class='bx bxs-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="dashboard.php">Tableau de bord</a>
                <a href="#" class="active">Utilisateurs</a>
                <a href="offers.php">Offres</a>
            </nav>

            <div class="user-auth">
                
                <?php if(!empty($session_name)) : ?>
                    <div class="profile-box">
                        
                        <div class="avatar-circle"><?php echo strtoupper($admin['user_name'][0])?></div>

                        <div class="dropdown">
                            <a href="../includes/edit_profil_2.php">
                                <i class="fa-solid fa-pen-to-square"></i> 
                                Modifier le profil
                            </a>

                            <a href="../logout.php">
                                <i class="fas fa-right-from-bracket"></i>
                                Se déconnecter
                            </a>
                        </div>
                        
                    </div>
                <?php endif; ?>

            </div>

        </header>


        <section class="admin-users">

            <h2>Gestion des utilisateurs</h2>

            <div class="admin-users-filter">

                <button class="filter-btn active right" data-type="all">Tous</button>
                <button class="filter-btn top" data-type="student">Étudiants</button>
                <button class="filter-btn left" data-type="company">Entreprises</button>

            </div>

            <?php if (count($users) > 0): ?>

                <div class="user-list application-table">

                    <table>

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Nom</th>
                                <th>Rôle</th>
                                <th>Email</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($users as $user): ?>

                                <tr data-user-type="<?= htmlspecialchars($user['role']) ?>">

                                    <td><?php echo htmlspecialchars($user['id']) ?></td>
                                    <td><?php echo htmlspecialchars($user['name']) ?></td>
                                    <td>
                                        <?php
                                            $roles = [
                                                'student' => 'Étudiant', 
                                                'company' => 'Entreprise'
                                            ];
                                            $role = $user['role'] ;
                                            echo htmlspecialchars($roles[$role]) 
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <?php 
                                            //Formater la date en francais 
                                            if (!empty($user['created_at'])){
                                                $date = new DateTime($user['created_at']);
                                                $formatter = new IntlDateFormatter(
                                                    'fr_FR', 
                                                    IntlDateFormatter::LONG,
                                                    IntlDateFormatter::NONE,
                                                    'Africa/Kinshasa',
                                                    IntlDateFormatter::GREGORIAN,
                                                    'd MMMM yyyy'
                                                );
                                                $date_fr = $formatter->format($date);
                                            }
                                            echo 'Le ' . $date_fr ?? '_';
                                        ?>
                                    </td>
                                    <td class="action">
                                        <a href="<?php if ($user['role'] == 'student') echo '../student/profil.php'; else echo '../company/profil.php'; ?>?id=<?php echo $user['id'] ?>" class="btn-action show" title="Voir le profil"><i class="fa-solid fa-eye"></i></a> 
                                        <a href="drop_user.php?id=<?php echo $user['id'] ?>" class="btn-action delete offer-delete" title="Supprimer l'utilisateur"><i class="fa-solid fa-trash"></i></a>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else : ?>
                <p class="no-users">Aucun utilisateur trouvé.</p>
            <?php endif; ?>

        </section>

        <!--//////////////////////////////////////////////////////////-->
                    <!-- La boîte de confirmation -->
        <div id="confirm-modal" class="modal-overlay">

            <div class="modal-content">

                <h4>Confirmer l'action</h4>

                <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>

                <div class="modal-buttons">
                    <button id="confirm-yes" class="reject">Oui, supprimer</button>
                    <button id="confirm-no" class="cancel">Annuler</button>
                </div>
                
            </div>

        </div>



        <!--////////////////////////////////////////////////////-->
                    <!-- footer -->
        <?php include '../includes/footer.php' ?>


        <!--//////////////////////////////////////////////////////////-->
                    <!--Partie du scroll reveal-->
        <script src="https://unpkg.com/scrollreveal"></script>


        <!--////////////////////////////////////////////////////-->
                    <!--scripts-->
        <script src="../assets/js/script.js"></script>

    </body>

</html>
