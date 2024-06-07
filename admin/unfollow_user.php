<?php 
include("./../server/connection.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Controlla se l'utente è loggato
  if(isset($_SESSION['user_id'])) {
    // Verifica se l'ID dell'utente da smettere di seguire è stato passato
    if(isset($_POST['followed_id'])) {
      $follower_id = $_SESSION['user_id']; // Utilizza l'ID dell'utente corrente
      $followed_id = $_POST['followed_id']; // Utilizza l'ID dell'utente da smettere di seguire

      // Esegui la query per rimuovere la relazione di follow dalla tabella 'follow'
      $query = "DELETE FROM follow WHERE follower_id = ? AND followed_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ii", $follower_id, $followed_id);

      if($stmt->execute()) {
        // Rispondi con successo e un messaggio di conferma
        http_response_code(200);
        echo json_encode(array("message" => "Unfollowed successfully"));
      } else {
        // Errore nell'esecuzione della query
        http_response_code(500);
        echo json_encode(array("message" => "Error executing query: " . $stmt->error));
      }
    } else {
      // Errore: l'ID dell'utente da smettere di seguire non è stato fornito
      http_response_code(400);
      echo json_encode(array("message" => "Followed ID not provided"));
    }
  } else {
    // Errore: l'utente non è loggato
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized user"));
  }
} else {
  // Errore: metodo di richiesta non consentito
  http_response_code(405);
  echo json_encode(array("message" => "Method not allowed"));
}
?>

<!--// Attendi il caricamento completo del documento HTML prima di eseguire lo script
document.addEventListener('DOMContentLoaded', function () {
    // Aggiungi un listener per il click su tutti gli elementi con la classe "unfollow-button"
    document.querySelectorAll('.unfollow-button').forEach(function (button) {
        button.addEventListener('click', function () {
            // Ottieni l'ID dell'utente da smettere di seguire dall'attributo data
            var followedId = this.dataset.followedId;

            // Esegui una richiesta AJAX per unfolloware l'utente
            fetch('../admin/unfollow_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ followed_id: followedId })
            })
            .then(response => {
                // Controlla lo stato della risposta
                if (response.ok) {
                    // Se la richiesta è andata a buon fine, aggiorna l'interfaccia utente
                    // Ad esempio, rimuovendo l'elemento dalla lista dei followed
                    this.closest('.follower').remove();
                } else {
                    // Se la richiesta non è andata a buon fine, mostra un messaggio di errore
                    console.error('Errore durante la richiesta: ' + response.statusText);
                }
            })
            .catch(error => {
                // Gestisci eventuali errori di rete o altri errori
                console.error('Si è verificato un errore:', error);
            });
        });
    });
});
*/>>
