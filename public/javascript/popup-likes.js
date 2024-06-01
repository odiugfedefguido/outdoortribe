// Funzione per aprire il popup e caricare i nomi degli utenti che hanno messo like al post
function openPopup(postId) {
  // Verifica se l'ID del post è stato fornito
  if (!postId) {
    console.error('ID del post non fornito');
    return;
  }

  // Seleziona il popup
  var popup = document.getElementById("like-popup");
  // Mostra il popup
  popup.style.display = "block";

  // Esegui una richiesta AJAX per ottenere i nomi degli utenti che hanno messo like per il post specificato
  fetch('../admin/get_likes.php?post_id=' + postId)
    .then(response => response.json())
    .then(data => {
      // Aggiorna il contenuto del popup con i nomi degli utenti ottenuti dalla risposta
      var likesList = document.getElementById('likes-list');
      likesList.innerHTML = ''; // Pulisci la lista dei like
      data.forEach(user => {
        var li = document.createElement('li');
        var link = document.createElement('a');
        link.href = 'otherprofile.php?id=' + user.id; // Crea il link al profilo dell'utente
        link.textContent = user.name;
        li.appendChild(link);
        likesList.appendChild(li);
      });
    })
    .catch(error => console.error('Si è verificato un errore durante il recupero dei like:', error));
}

// Funzione per chiudere il popup
function closePopup() {
  var popup = document.getElementById("like-popup");
  popup.style.display = "none";
}

// Otteniamo tutti gli elementi con la classe "likes-count"
var likesCounts = document.querySelectorAll('.likes-count');

// Aggiungiamo un gestore di eventi a ciascun elemento
likesCounts.forEach(function (likesCount) {
  likesCount.addEventListener('click', function (event) {
    event.stopPropagation(); // Evita la propagazione dell'evento clic ai genitori

    // Ottieni l'ID del post associato al paragrafo cliccato
    var postId = this.dataset.postId;

    // Passa l'ID del post alla funzione openPopup
    openPopup(postId);
  });
});

// Aggiungi un gestore di eventi al clic sulla finestra del browser per chiudere il popup
window.addEventListener('click', function (event) {
  var popup = document.getElementById("like-popup");
  // Chiudi il popup se il clic non è avvenuto sul popup stesso o sui suoi figli
  if (event.target !== popup && !popup.contains(event.target)) {
    closePopup();
  }
});
