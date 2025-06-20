
/*-----------------------------------------------------------------------------------------------------*/
/* Déclaration des variables */
const authModal = document.querySelector('.auth-modal');
const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');
const loginBtnModal = document.querySelector('.login-btn-modal');
const closeBtnModal = document.querySelector('.close-btn-modal');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

const profilBox = document.querySelector('.profile-box');
const avatarCircle = document.querySelector('.avatar-circle');

const alertBox = document.querySelector('.alert-box');

/*-----------------------------------------------------------------------------------------------------*/
/* Le slide pour l'authentification */
if(authModal){
    registerLink.addEventListener('click', () => {authModal.classList.add('slide')});
    loginLink.addEventListener('click', () => {authModal.classList.remove('slide')});
}

/*-----------------------------------------------------------------------------------------------------*/
/* L'affichage de l'authentification */
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
/* La fermeture du menu de navigation en responsive */
if(loginBtnModal)
    loginBtnModal.addEventListener('click', () => {
        menuIcon.classList.remove('bxs-x');
        navbar.classList.remove('active');
    });

/*-----------------------------------------------------------------------------------------------------*/
/* L'affichage du profil */
if(profilBox)
    avatarCircle.addEventListener('click', () =>{
        profilBox.classList.toggle('show');
    });

/*-----------------------------------------------------------------------------------------------------*/
/* L'affichage de l'alerte */
if (alertBox){
    setTimeout(() => alertBox.classList.add('show'), 50);

    setTimeout(() =>{
        alertBox.classList.remove('show');
        setTimeout(() => alertBox.remove, 1000);
    }, 3000);
}

/*-----------------------------------------------------------------------------------------------------*/
/* Scroll reveal*/
let params = { 
    reset: false,
    distance: '60px',
    duration: 1500,
    delay: 200
};
ScrollReveal(params);

ScrollReveal().reveal('.site-name, .reveal-top, .about-header-content h2, .about-header-content h3, .about-missions h2, .add-offer h2, .view-offer h2, .offer-details-container h2, .profil-info h2, .edit-profil h2, .dashboard-card-container .dashboard-card-content.right', {origin : 'top'});
ScrollReveal().reveal('.home-header-content h1, .home-header-content p, .home-header-content .btn-home-header-content, .reveal-bottom, .about-header-content p, .about-header-content a, .about-mission-box, .add-offer form .add-offer-btn, .view-offer .offer-box .offer-card, .offer-details a, .profil-info .profil-info-container, .edit-profil .edit-profil-input-box, .edit-profil .edit-profil-btn, .dashboard-card-container .dashboard-card-content.left ', {origin : 'bottom'});
ScrollReveal().reveal('.home-student-img, .home-company-content, .contact-content, .add-offer form .add-offer-input-box, .view-offer .no-offer,  .offer-details-box p, .dashboard-card-header .dashboard-card-box', {origin : 'left'});
ScrollReveal().reveal('.contact-img', {origin : 'right'});

