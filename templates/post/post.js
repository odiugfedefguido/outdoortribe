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
