<?php

session_start();
include("./../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verifica se l'utente è loggato
  if (!isset($_SESSION['user_id'])) {
    die("Errore: utente non loggato.");
  }

  $user_id = $_SESSION['user_id'];
  $title = $_POST['title'];
  $location = $_POST['location'];
  $activity = ucfirst($_POST['activity']);
  $likes = 0;
  $length = $_POST['distance'];
  $duration = $_POST['duration'];

  // Debug: stampa i valori ricevuti
  error_log("User ID: $user_id, Title: $title, Location: $location, Activity: $activity, Distance: $length");

  // Preparazione della query per evitare SQL Injection
  $insertQuery = "INSERT INTO post (user_id, title, location, activity,  duration, length, likes) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $insertStmt = $conn->prepare($insertQuery);
  if ($insertStmt === false) {
    die('Prepare failed: ' . $conn->error);
  }

  // Binding dei parametri
  $insertStmt->bind_param('issssdi', $user_id, $title, $location, $activity, $duration, $length, $likes);
  // Esecuzione della query
  if ($insertStmt->execute()) {
    // Ottieni l'ID dell'ultimo inserimento
    $post_id = $insertStmt->insert_id;

    // Salva l'ID del post in una sessione o passalo come parametro alla prossima pagina
    $_SESSION['post_id'] = $post_id;
    // Reindirizzamento alla pagina di controllo dopo l'inserimento
    header("Location: ./../public/check.php");
    exit();
  } else {
    // Gestione dell'errore
    error_log("Errore nell'inserimento dei dati: " . $insertStmt->error);
  }
} else {
  echo "Metodo di richiesta non valido.";
}