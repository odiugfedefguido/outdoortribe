<?php
session_start();
include("./../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ricevi l'ID del post dalla richiesta POST
  $postId = $_POST['postId'];

  // Ricevi l'ID dell'utente loggato
  $userId = 5; //$_SESSION['user_id']; 

  // Controlla se l'utente ha già messo like a questo post
  $checkQuery = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
  $checkStmt = $conn->prepare($checkQuery);
  $checkStmt->bind_param("ii", $postId, $userId);
  $checkStmt->execute();
  $checkResult = $checkStmt->get_result();

  // Ottieni il numero di likes del post prima di aggiornare il database
  $getLikesQuery = "SELECT likes FROM post WHERE id = ?";
  $getLikesStmt = $conn->prepare($getLikesQuery);
  $getLikesStmt->bind_param("i", $postId);
  $getLikesStmt->execute();
  $likesResult = $getLikesStmt->get_result();
  $likes = $likesResult->fetch_assoc()['likes'];


  if ($checkResult->num_rows > 0) {
    // Se l'utente ha già messo like, rimuovi il like dal database
    $deleteQuery = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $postId, $userId);
    $deleteStmt->execute();

    // Decrementa il conteggio dei like nel post
    $likes--;

    // Aggiorna il numero di like del post nel database
    $updateLikesQuery = "UPDATE post SET likes = ? WHERE id = ?";
    $updateLikesStmt = $conn->prepare($updateLikesQuery);
    $updateLikesStmt->bind_param("ii", $likes, $postId);
    $updateLikesStmt->execute();

    // Restituisci la risposta come JSON con il numero aggiornato di like
    echo json_encode(array('action' => 'unlike', 'likes' => $likes));
  } else {
    // Se l'utente non ha ancora messo like, aggiungi il like nel database
    $insertQuery = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ii", $postId, $userId);
    $insertStmt->execute();

    // Incrementa il conteggio dei like nel post
    $likes++;

    // Aggiorna il numero di like del post nel database
    $updateLikesQuery = "UPDATE post SET likes = ? WHERE id = ?";
    $updateLikesStmt = $conn->prepare($updateLikesQuery);
    $updateLikesStmt->bind_param("ii", $likes, $postId);
    $updateLikesStmt->execute();

    //aggiorno la tabella notifiche
    $insertNotificationQuery = "INSERT INTO notifications (user_id, source_user_id, type) VALUES (?, ?, 'like')";
    $insertNotificationStmt = $conn->prepare($insertNotificationQuery);
    $insertNotificationStmt->bind_param("ii", $userId, $postId);
    $insertNotificationStmt->execute();


    // Restituisci la risposta come JSON con il numero aggiornato di like
    echo json_encode(array('action' => 'like', 'likes' => $likes));
  }
}
