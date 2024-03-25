// Selezioniamo l'icona del menu e la navbar
const menuIcon = document.querySelector('.menu-icon');
const menu = document.querySelector('.menu');

// Aggiungiamo un evento di click all'icona del menu
menuIcon.addEventListener('click', function() {
    // Toggle della classe 'active' sulla navbar
    menu.classList.toggle('active');
});