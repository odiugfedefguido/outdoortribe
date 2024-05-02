<?php
include("./../server/connection.php");

// Assicurati che l'ID del post sia stato fornito tramite la richiesta GET
if (isset($_GET['post_id'])) {
  $postId = $_GET['post_id'];

  // Esegui la query per ottenere i nomi degli utenti che hanno messo like per il post specificato
  $likesQuery = "SELECT user.name, user.surname 
                 FROM likes 
                 INNER JOIN user ON likes.user_id = user.id 
                 WHERE likes.post_id = ?";
  $stmt = $conn->prepare($likesQuery);
  $stmt->bind_param("i", $postId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Costruisci la risposta da restituire al client
  $likes = array();
  while ($row = $result->fetch_assoc()) {
    // Concatena il nome e il cognome dell'utente e aggiungilo all'array dei like
    $likes[] = $row['name'] . ' ' . $row['surname'];
  }

  // Converti l'array in una stringa JSON e restituisci la risposta al client
  echo json_encode($likes);
} else {
  // Restituisci un messaggio di errore se non è stato fornito un ID del post
  echo "Errore: ID del post non fornito";
}

// Chiudi la connessione al database
$conn->close();
