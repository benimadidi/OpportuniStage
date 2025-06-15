
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

        <form action="./controllers/auth_process.php" method="POST">

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

        <div class="input-box">
            <input type="password" name="password-confirm" placeholder="Confirmer votre mot de passe" required>
            <i class='bx  bxs-lock'  ></i> 
        </div>

        <!-- Rôles -->
        <div class="input-box">
            <select name="role" id="role" required>
                <option value="" disabled selected>Qui êtes vous ?</option>
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