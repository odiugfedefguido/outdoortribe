<?php
include("./../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ricevi l'ID del post dalla richiesta POST
  $postId = $_POST['postId'];

  // Ricevi l'ID dell'utente loggato
  $userId = 5; //$_SESSION['user_id']; // Assicurati che $_SESSION['user_id'] sia impostato correttamente durante l'accesso dell'utente

  // Controlla se l'utente ha già messo like a questo post
  $checkQuery = "SELECT * FROM likes WHERE post_id = $postId AND user_id = $userId";
  $checkResult = mysqli_query($conn, $checkQuery);

  // Ottieni il numero di likes del post prima di aggiornare il database
  $getLikesQuery = "SELECT likes FROM post WHERE id = $postId";
  $likesResult = mysqli_query($conn, $getLikesQuery);
  $likes = mysqli_fetch_assoc($likesResult)['likes'];

  if (mysqli_num_rows($checkResult) > 0) {
    // Se l'utente ha già messo like, rimuovi il like dal database
    $deleteQuery = "DELETE FROM likes WHERE post_id = $postId AND user_id = $userId";
    mysqli_query($conn, $deleteQuery);

    // Decrementa il conteggio dei like nel post
    $likes--;

    // Aggiorna il numero di like del post nel database
    $updateLikesQuery = "UPDATE post SET likes = $likes WHERE id = $postId";
    mysqli_query($conn, $updateLikesQuery);

    // Restituisci la risposta come JSON con il numero aggiornato di like
    echo json_encode(array('action' => 'unlike', 'likes' => $likes));
  } else {
    // Se l'utente non ha ancora messo like, aggiungi il like nel database
    $insertQuery = "INSERT INTO likes (post_id, user_id) VALUES ($postId, $userId)";
    mysqli_query($conn, $insertQuery);

    // Incrementa il conteggio dei like nel post
    $likes++;

    // Aggiorna il numero di like del post nel database
    $updateLikesQuery = "UPDATE post SET likes = $likes WHERE id = $postId";
    mysqli_query($conn, $updateLikesQuery);

    // Restituisci la risposta come JSON con il numero aggiornato di like
    echo json_encode(array('action' => 'like', 'likes' => $likes));
  }
}
