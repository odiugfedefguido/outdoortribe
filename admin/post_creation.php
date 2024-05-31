<?php

session_start();
include("./../server/connection.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['user_id'];
  $title = $_POST['title'];
  $location = $_POST['location'];
  $activity = ucfirst($_POST['activity']);

  // Debug: stampa i valori ricevuti
  /* echo "User ID: $user_id, Title: $title, Location: $location, Activity: $activity"; */

  // Preparazione della query per evitare SQL Injection
  $insertQuery = "INSERT INTO post (user_id, title, location, activity) VALUES (?, ?, ?, ?);";
  $insertStmt = $conn->prepare($insertQuery);
  if($insertStmt === false) {
    die('Prepare failed: ' . $conn->error);
  }

  // Binding dei parametri
  $insertStmt->bind_param('isss', $user_id, $title, $location, $activity);
  // Esecuzione della query
  if($insertStmt->execute()) {
    // Ottieni l'ID dell'ultimo inserimento
    $post_id = $insertStmt->insert_id;

    // Salva l'ID del post in una sessione o passalo come parametro alla prossima pagina
    $_SESSION['post_id'] = $post_id;
    // Reindirizzamento alla pagina di controllo dopo l'inserimento
    header("Location: ./../public/check.php");
    exit();
  } else {
    // Gestione dell'errore
    echo "Errore nell'inserimento dei dati: " . $stmt->error;
  }
}