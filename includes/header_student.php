
<header class="header">

    <a href="#" class="logo">OpportuniStage</a>

    <i class='bx bxs-menu' id="menu-icon"></i>

    <nav class="navbar">
        <a href="./student/dashboard.php" class="active">Tableau de bord</a>
        <a href="./offers.php">Offres de stage</a>
        <a href="./applications.php">Mes candidatures</a>
    </nav>

    <div class="user-auth">
        
        <?php if(!empty($session_name)) : ?>
            <div class="profile-box">
                
                <div class="avatar-circle"><?= strtoupper($session_name[0])?></div>

                <div class="dropdown">
                    <a href="./admin/profile.php">
                        <i class='bx  bxs-user'  ></i> 
                        Mon Profil
                    </a>

                    <a href="logout.php">
                        <i class="fas fa-right-from-bracket"></i>
                        Se déconnecter
                    </a>
                </div>
                
            </div>
        <?php endif; ?>

    </div>

</header>
