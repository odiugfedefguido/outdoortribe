// Seleziona il bottone della foto del profilo e il menu a tendina
const profileMenuButton = document.getElementById('profileMenuButton');
const dropdownMenu = document.getElementById('dropdownMenu');

// Aggiungi un evento di click al bottone della foto del profilo
profileMenuButton.addEventListener('click', function() {
    // Mostra o nascondi il menu a tendina quando il bottone viene cliccato
    dropdownMenu.classList.toggle('show');
});

// Chiudi il menu a tendina se l'utente clicca fuori da esso
window.onclick = function(event) {
    if (!event.target.matches('.profile-icon-button')) {
        const dropdowns = document.getElementsByClassName('dropdown-menu');
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
