<?php

session_start();

$name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$active_form = $_SESSION['active_form'] ?? '';

session_unset();

if ($name !== null)
    $_SESSION['name'] = $name;

?>

<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test</title>

        <link rel="stylesheet" href="style.css">
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
        
        <header>

            <a href="#" class="logo">Logo</a>

            <nav>
                <a href="#">Acceuil</a>
                <a href="#">A propos</a>
                <a href="#">Collection</a>
                <a href="#">Contact</a>
            </nav>

            <div class="user-auth">
                <?php if(!empty($name)) :  ?>
                    <div class="profile-box">
                        <div class="avatar-circle"><?= strtoupper($name[0]);?></div>
                        <div class="dropdown">
                            <a href="#">Mon compte</a>
                            <a href="logout.php">Se deconnecter</a>
                        </div>
                    </div>
                <?php else : ?>
                    <button type="button" class="login-btn-modal">Se connecter</button>
                <?php endif; ?>
            </div>

        </header>

        <section>
            <h1>Bonjour <?= $name ?? 'Developpeur' ?> !</h1>
        </section>

        <?php if(!empty($alerts)) :  ?>
            <div class="alert-box">
                <?php foreach($alerts as $alert) : ?>
                    <div class="alert <?= $alert['type']; ?>">
                        <i class="bx  <?= $alert['type'] === 'success' ? 'bxs-check-circle' : 'bxs-x-circle'; ?>" ></i> 
                        <p><?= $alert['message']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="auth-modal <?= $active_form === 'register' ? 'show slide' : ($active_form === 'login' ? 'show' : ''); ?>">

            <button type="button" class="close-btn-modal"><i class='bx  bxs-x' ></i> </button>

            <div class="form-box login">

                <h2>Se connecter</h2>

                <form action="auth_process.php" method="POST">

                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required>
                        <i class='bx  bxs-envelope'  ></i> 
                    </div>

                    <div class="input-box">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                        <i class='bx  bxs-lock'  ></i> 
                    </div>

                    <button type="submit" name="login_btn" class="btn">Se connecter</button>

                    <p>Vous n'avez pas de compte ? <a href="#" class="register-link">S'inscrire</a></p>

                </form>
            </div>


            <div class="form-box register">

                <h2>S'inscrire</h2>

                <form action="auth_process.php" method="POST">

                    <div class="input-box">
                        <input type="name" name="name" placeholder="Nom" required>
                        <i class='bx  bxs-user'  ></i> 
                    </div>

                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required>
                        <i class='bx  bxs-envelope'  ></i> 
                    </div>

                    <div class="input-box">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                        <i class='bx  bxs-lock'  ></i> 
                    </div>

                    <button type="submit" name="register_btn" class="btn">S'inscrire</button>

                    <p>Vous avez déjà un compte ? <a href="#" class="login-link">Se connecter</a></p>

                </form>
            </div>

        </div>

        <script src="script.js"></script>

    </body>
    
</html>