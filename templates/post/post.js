// Attendi il caricamento completo del documento HTML prima di eseguire lo script
document.addEventListener('DOMContentLoaded', function () {
  // Aggiungi un listener per il click su tutto il documento
  document.addEventListener('click', function (event) {
    // Verifica se l'elemento cliccato è un'icona del like
    if (event.target.classList.contains('like-icon')) {
      // Ottieni l'ID del post associato all'icona del like
      var postId = event.target.dataset.postId;
      // Esegui la funzione per mettere like al post
      likePost(postId);
    }
  });

  // Funzione per mettere like a un post
  function likePost(postId) {
    // Esegui una richiesta AJAX per mettere like al post
    $.ajax({
      url: '../admin/like_post.php', // URL del file PHP per mettere like al post
      type: 'POST', // Metodo di richiesta HTTP
      data: { postId: postId }, // Dati da inviare con la richiesta POST
      success: function (response) { // Funzione da eseguire in caso di successo
        // Parsifica la risposta JSON ricevuta dal server
        var responseObj = JSON.parse(response);
        // Ottieni l'elemento che mostra il conteggio dei like per questo post
        var likeCountElement = $('#likes-' + postId);
        // Ottieni il nuovo conteggio dei like dalla risposta JSON
        var currentLikes = responseObj.likes;
        // Aggiorna il testo mostrato per il conteggio dei like
        likeCountElement.text(currentLikes);

        // Aggiungi o rimuovi la classe 'liked' dall'icona del like a seconda dello stato aggiornato
        var likeIcon = $('.like-icon[data-post-id="' + postId + '"]');
        likeIcon.toggleClass('liked');
      },
      error: function (xhr, status, error) { // Funzione da eseguire in caso di errore
        // Gestisci eventuali errori stampando un messaggio nella console del browser
        console.error("Errore durante la chiamata AJAX:", error);
      }
    });
  }

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

});
