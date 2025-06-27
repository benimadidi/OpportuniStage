
/*-----------------------------------------------------------------------------------------------------*/
/* Déclaration des variables */

// Auth modal et ses boutons
const authModal = document.querySelector('.auth-modal');
const loginBtnModal = document.querySelector('.login-btn-modal');
const closeBtnModal = document.querySelector('.close-btn-modal');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

// Menu responsive
const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');

// Profil
const profilBox = document.querySelector('.profile-box');
const avatarCircle = document.querySelector('.avatar-circle');

// Alerte dynamique
const alertBox = document.querySelector('.alert-box');


// Filtrage tableau utilisateurs (admin)
const filterBtns = document.querySelectorAll(".filter-btn");
const tableRows = document.querySelectorAll(".user-list tbody tr"); 

// Modale de confirmation
const modal = document.getElementById('confirm-modal');
const btnYes = document.getElementById('confirm-yes');
const btnNo = document.getElementById('confirm-no');
const rejectBtn = document.querySelectorAll('.reject-btn');
const rejectBtnLink = document.querySelectorAll('.offer-delete');
let formToSubmit = null;
let linkToRedirect = null;

/*-----------------------------------------------------------------------------------------------------*/
/* Slide entre Connexion et Inscription */
if(authModal){
    registerLink.addEventListener('click', () => {authModal.classList.add('slide')});
    loginLink.addEventListener('click', () => {authModal.classList.remove('slide')});
}

/*-----------------------------------------------------------------------------------------------------*/
/* Ouverture/Fermeture de la modal */
if(loginBtnModal){
    loginBtnModal.addEventListener('click', () => {authModal.classList.toggle('show')});
    closeBtnModal.addEventListener('click', () => {authModal.classList.remove('show', 'slide')});
}

/*-----------------------------------------------------------------------------------------------------*/
/* Le menu de navigation en responsive */
if (menuIcon){
    menuIcon.addEventListener('click', () => {
        menuIcon.classList.toggle('bxs-x');
        navbar.classList.toggle('active');
    });
}

/*-----------------------------------------------------------------------------------------------------*/
/* Ferme le menu si on ouvre la modal */
if(loginBtnModal)
    loginBtnModal.addEventListener('click', () => {
        menuIcon.classList.remove('bxs-x');
        navbar.classList.remove('active');
    });

/*-----------------------------------------------------------------------------------------------------*/
/* Affichage de la box profil */
if(profilBox)
    avatarCircle.addEventListener('click', () =>{
        profilBox.classList.toggle('show');
    });

/*-----------------------------------------------------------------------------------------------------*/
/* Affichage des alertes avec disparition automatique */
if (alertBox){
    setTimeout(() => alertBox.classList.add('show'), 50);

    setTimeout(() =>{
        alertBox.classList.remove('show');
        setTimeout(() => alertBox.remove, 1000);
    }, 3000);
}

/*-----------------------------------------------------------------------------------------------------*/
/* Filtrage des utilisateurs (admin) */
filterBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        // Retire la classe active du bouton précédent
        document.querySelector(".filter-btn.active").classList.remove("active");
        btn.classList.add("active");

        const selectedType = btn.getAttribute("data-type");

        tableRows.forEach(row => {
            const userType = row.getAttribute("data-user-type");

            if (selectedType === "all" || userType === selectedType) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});

/*-----------------------------------------------------------------------------------------------------*/
/* Confirmation sur les actions sensibles (supprimer) */
if (modal) {
    // Cas bouton avec formulaire
    rejectBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            formToSubmit = btn.closest('form');   
            modal.classList.add('show');
        });
    });

    // Cas bouton avec lien
    rejectBtnLink.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            linkToRedirect = link.getAttribute('href');
            modal.classList.add('show');
        });
    });

    // Bouton Oui
    btnYes.addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit();
            formToSubmit = null;
        }
        if (linkToRedirect) {
            window.location.href = linkToRedirect;
            linkToRedirect = null;
        }
        modal.classList.remove('show');
    });

    // Bouton Non
    btnNo.addEventListener('click', () => {
        modal.classList.remove('show');
        formToSubmit = null;
        linkToRedirect = null;
    });
}

/*-----------------------------------------------------------------------------------------------------*/
/* Animations avec ScrollReveal */
const params = { 
    reset: false,
    distance: '60px',
    duration: 1500,
    delay: 200
};
ScrollReveal(params);

ScrollReveal().reveal(
    '.site-name, .reveal-top, .about-header-content h2, .about-header-content h3, .about-missions h2, .add-offer h2, .view-offer h2, .offer-details-container h2, .profil-info h2, .edit-profil h2, .dashboard-card-container .dashboard-card-content.right', 
    {origin : 'top'}
);

ScrollReveal().reveal(
    '.home-header-content h1, .home-header-content p, .home-header-content .btn-home-header-content, .reveal-bottom, .about-header-content p, .about-header-content a, .about-mission-box, .add-offer form .add-offer-btn, .view-offer .offer-box .offer-card, .offer-details a, .profil-info .profil-info-container, .edit-profil .edit-profil-input-box, .edit-profil .edit-profil-btn, .dashboard-card-container .dashboard-card-content.left, .offer-box-companies ', 
    {origin : 'bottom'}
);

ScrollReveal().reveal(
    '.home-student-img, .home-company-content, .contact-content, .add-offer form .add-offer-input-box, .view-offer .no-offer,  .offer-details-box p, .dashboard-card-header .dashboard-card-box, .offer-details a', 
    {origin : 'left'}
);

ScrollReveal().reveal(
    '.contact-img', 
    {origin : 'right'}
);
