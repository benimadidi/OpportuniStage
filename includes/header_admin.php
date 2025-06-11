
<header class="header">

    <a href="#" class="logo">OpportuniSatge</a>

    <i class='bx bxs-menu' id="menu-icon"></i>

    <nav class="navbar">
        <a href="./admin/dashboard.php" class="active">Tableau de bord</a>
        <a href="./admin/manage_users.php">Utilisateurs</a>
        <a href="./admin/manage_offers.php">Offres</a>
        <a href="./admin/settings.php">Paramètres</a>
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
