//Script JavaScript per gestire il follow/unfollow
  
    document.addEventListener('DOMContentLoaded', function() {
      var followButtons = document.querySelectorAll('.follow-btn');
      followButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.preventDefault();
          var followedId = this.getAttribute('data-id');
          var action = this.innerText === 'Follow' ? 'follow' : 'unfollow';
          
          // Effettua una richiesta fetch per eseguire l'azione di follow/unfollow
          fetch('./../admin/follow_unfollow.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=' + action + '&followed_id=' + followedId
          })
          .then(response => response.text())
          .then(data => {
            if (data === 'success') {
              location.reload(); // Ricarica la pagina dopo aver eseguito con successo l'azione di follow/unfollow
            } else {
              alert('Error: ' + data); // Mostra un messaggio di errore se l'azione non ha avuto successo
            }
          });
        });
      });
    });

    