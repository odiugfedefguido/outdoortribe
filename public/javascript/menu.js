// Selezioniamo l'icona del menu e la navbar
const menuIcon = document.querySelector('.menu-icon'); // Seleziona l'elemento con la classe 'menu-icon'
const menu = document.querySelector('.menu'); // Seleziona l'elemento con la classe 'menu'

// Aggiungiamo un evento di click all'icona del menu
menuIcon.addEventListener('click', function () {
    // Toggle della classe 'active' sulla navbar per aprire o chiudere il menu
    menu.classList.toggle('active');
});
