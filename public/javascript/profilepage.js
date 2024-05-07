document.addEventListener("DOMContentLoaded", function() {
    // Aggiungi un gestore per il clic sul pulsante "Rimuovi foto profilo"
    document.getElementById("remove_photo_btn").addEventListener("click", function(event) {
        event.preventDefault(); // Evita il comportamento predefinito del link

        // Conferma con l'utente prima di procedere con l'eliminazione
        if (confirm("Sei sicuro di voler rimuovere la foto del profilo?")) {
            // Invia una richiesta AJAX per eliminare la foto del profilo
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./../public/remove_profile_photo.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Se la richiesta è stata completata con successo, aggiorna la pagina
                        window.location.reload();
                    } else {
                        // Altrimenti, gestisci l'errore in base alla risposta del server
                        console.error("Errore durante l'eliminazione della foto del profilo:", xhr.responseText);
                        alert("Si è verificato un errore durante l'eliminazione della foto del profilo. Riprova più tardi.");
                    }
                }
            };
            xhr.send(); // Invia la richiesta
        }
    });
});
