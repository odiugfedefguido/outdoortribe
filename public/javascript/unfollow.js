document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.unfollow-button').forEach(function (button) {
        button.addEventListener('click', function () {
            var followedId = this.dataset.followedId;

            fetch('../admin/unfollow_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ followed_id: followedId })
            })
            .then(response => {
                if (response.ok) {
                    // Alert per notificare che l'unfollow è stato eseguito con successo
                    alert('Unfollow eseguito con successo!');
                    // Rimuovi l'elemento dalla lista dei followed
                    this.closest('.follower').remove();
                } else {
                    console.error('Errore durante la richiesta: ' + response.statusText);
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
        });
    });
});
