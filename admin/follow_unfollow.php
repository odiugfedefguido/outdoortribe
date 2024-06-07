<?php
session_start(); // Avvia la sessione per accedere alle variabili di sessione
include("./../server/connection.php"); // Includi il file di connessione al database

// Ottieni l'ID dell'utente corrente dalla sessione, se presente
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Ottieni l'azione (follow o unfollow), se presente
$action = isset($_POST['action']) ? $_POST['action'] : null;

// Ottieni l'ID dell'utente seguito, se presente
$followed_id = isset($_POST['followed_id']) ? intval($_POST['followed_id']) : null;

// Verifica che tutti i parametri necessari siano presenti
if ($current_user_id && $followed_id && $action) {
  // Prepara la query SQL in base all'azione richiesta (follow o unfollow)
  if ($action === 'follow') {
    $query = "INSERT INTO follow (follower_id, followed_id) VALUES (?, ?)"; // Se l'azione è "follow", inserisci una nuova riga nella tabella follow
  } else if ($action === 'unfollow') {
    $query = "DELETE FROM follow WHERE follower_id = ? AND followed_id = ?"; // Se l'azione è "unfollow", elimina la riga corrispondente dalla tabella follow
  }

  // Prepara e esegui la query SQL
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $current_user_id, $followed_id);

  // Esegui la query e controlla se ha avuto successo
  if ($stmt->execute()) {
    echo 'success'; // Se ha avuto successo, restituisci "success" come risposta
  } else {
    echo 'error'; // Se c'è stato un errore nell'esecuzione della query, restituisci "error" come risposta
  }

  // Chiudi lo statement
  $stmt->close();
}

// Chiudi la connessione al database
$conn->close();
?>
