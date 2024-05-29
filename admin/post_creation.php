<?php

session_start();
include("./../server/connection.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['user_id'];
  $title = $_POST['title'];
  $location = $_POST['location'];
  $activity = $_POST['activity'];

  $activity = ucfirst($activity);

  // Debug: stampa i valori ricevuti
  echo "User ID: $user_id, Title: $title, Location: $location, Activity: $activity";

  // Preparazione della query per evitare SQL Injection
  $stmt = $conn->prepare("INSERT INTO post (user_id, title, location, activity) VALUES (?, ?, ?, ?)");
  if($stmt === false) {
    die('Prepare failed: ' . $conn->error);
  }

  // Binding dei parametri
  $stmt->bind_param('isss', $user_id, $title, $location, $activity);
  
  // Esecuzione della query
  if($stmt->execute()) {
    // Reindirizzamento alla pagina di controllo dopo l'inserimento
    header("Location: ./../public/check.php");
    exit();
  } else {
    // Gestione dell'errore
    echo "Errore nell'inserimento dei dati: " . $stmt->error;
  }
}