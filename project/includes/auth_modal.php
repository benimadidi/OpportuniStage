
<!--//////////////////////////////////////////////////////////////////////////////////////////-->
            <!-- Modal d'authentification -->
<div class="auth-modal <?php echo $active_form === 'register' ? 'show slide' : ($active_form === 'login' ? 'show' : ''); ?>">

    <!-- Bouton pour fermer la modal -->
    <button type="button" class="close-btn-modal"><i class='bx  bxs-x' ></i></button>

    <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                <!--Formulaire de connexion-->
    <div class="form-box login">

        <h2>Se connecter</h2>

        <form action="./controllers/auth_process.php" method="POST">

        <!-- Champ email -->
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <i class="bx  bxs-envelope"></i>
        </div>

        <!-- Champ mot de passe -->
        <div class="input-box">
            <input type="password" name="password" placeholder="Mot de passe" required>
            <i class='bx  bxs-lock'  ></i> 
        </div>

        <!-- Bouton soumettre formulaire connexion -->
        <button type="submit" name="login-btn" class="btn">Se connecter</button>

        <!-- Lien pour aller vers le formulaire d'inscription -->
        <p>Vous n'avez pas de compte ? <a href="#" class="register-link">S'inscrire</a></p>

        </form>

    </div>

    <!--//////////////////////////////////////////////////////////////////////////////////////////-->
                <!--Formulaire d'inscription-->
    <div class="form-box register">
        
        <h2>S'inscrire</h2>

        <form action="./controllers/auth_process.php" method="POST">

            <!-- Champ nom complet ou nom entreprise -->
            <div class="input-box">
                <input type="text" name="name" placeholder="Nom complet / Entreprise" required>
                <i class='bx  bxs-user'  ></i> 
            </div>    

            <!-- Champ email -->
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="bx  bxs-envelope"></i>
            </div>    

            <!-- Champ mot de passe -->
            <div class="input-box">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class='bx  bxs-lock'  ></i> 
            </div>

            <!-- Confirmation mot de passe -->
            <div class="input-box">
                <input type="password" name="password-confirm" placeholder="Confirmer votre mot de passe" required>
                <i class='bx  bxs-lock'  ></i> 
            </div>

            <!-- Sélection du rôle -->
            <div class="input-box">
                <select name="role" id="role" required>
                    <option value="" disabled selected>Qui êtes vous ?</option>
                    <option value="student">Etudiant</option>
                    <option value="company">Entreprise</option>
                    <!-- <option value="admin">Admin</option> -->
                </select>
            </div>

            <!-- Bouton soumettre formulaire inscription -->
            <button type="submit" name="register-btn" class="btn">S'inscrire</button>

            <!-- Lien pour aller vers le formulaire de connexion -->
            <p>Vous avez deja un compte ? <a href="#" class="login-link">Se connecter</a></p>

        </form>

    </div>

</div>