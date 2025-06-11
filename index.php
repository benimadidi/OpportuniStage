
<?php

/*-------------------------------------------------------*/
/* Gestion de l'affichage des erreurs */ 
error_reporting(-1);
ini_set('display_errors', 1);

session_start();

$session_name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['allerts'] ?? [];
$active_form = $_SESSION['active_form'] ?? '';

session_unset();

if ($session_name !== null)
    $_SESSION['name'] = $session_name ;

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
        <link rel="stylesheet" href="./assets/css/style.css">

        <!--////////////////////////////////////////////////////-->
        <!--Icons-->
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>

    <!--////////////////////////////////////////////////////-->
    <!-- header -->
    <?php include './includes/load_header.php' ?>

    <!--////////////////////////////////////////////////////-->
    <!-- Gestion des alertes -->
    <?php if(!empty($alerts)) : ?>
        <div class="alert-box">
            <?php foreach($alerts as $alert) : ?>
                <div class="alert <?= $alert['type'] ?>">
                    <i class="bx <?= $alert['message'] === 'success' ? 'bxs-check-circle' : 'bxs-x-circle'; ?>"></i>
                    <p><?= $alert['message'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!--////////////////////////////////////////////////////-->
    <!-- page de connexion -->
     <div class="auth-modal <?= $active_form === 'register' ? 'show slide' : ($active_form === 'login' ? 'show' : ''); ?>">

        <button type="button" class="close-btn-modal"><i class='bx  bxs-x' ></i></button>

        <!--////////////////////////////////////////////////////-->
        <!--Formulaire de connexion-->
        <div class="form-box login">

            <h2>Se connecter</h2>

            <form action="./controllers/auth_process.php" method="POST">

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="bx  bxs-envelope"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class='bx  bxs-lock'  ></i> 
            </div>

            <button type="submit" name="login-btn" class="btn">Se connecter</button>
            <p>Vous n'avez pas de compte ? <a href="#" class="register-link">S'inscrire</a></p>

            </form>

        </div>

        <!--////////////////////////////////////////////////////-->
        <!--Formulaire d'inscription-->
        <div class="form-box register">
            
            <h2>S'inscrire</h2>

            <form action="auth_process.php" method="POST">

            <div class="input-box">
                <input type="text" name="name" placeholder="Nom complet / Entreprise" required>
                <i class='bx  bxs-user'  ></i> 
            </div>    

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="bx  bxs-envelope"></i>
            </div>    

            <div class="input-box">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class='bx  bxs-lock'  ></i> 
            </div>

            <!-- Rôles -->
            <div class="input-box">
                <select name="role" id="role" required>
                    <option value="" disabled selected>Choisissez une option</option>
                    <option value="student">Etudiant</option>
                    <option value="company">Entreprise</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" name="register-btn" class="btn">S'inscrire</button>
            <p>Vous avez deja un compte ? <a href="#" class="login-link">Se connecter</a></p>

            </form>

        </div>

    </div>

    <!--////////////////////////////////////////////////////-->
    <!-- footer -->
    <?php include 'includes/footer.php' ?>

    <!--////////////////////////////////////////////////////-->
    <!--scripts-->
    <script src="./assets/js/script.js"></script>

    </body>

</html>