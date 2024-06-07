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
  $origin = $_POST['origin'];
  $destination = $_POST['destination'];
  $originKm = $_POST['originKm'];
  $destinationKm = $_POST['destinationKm'];

  // Preparazione della query per evitare SQL Injection
  $insertPostQuery = "INSERT INTO post (user_id, title, location, activity, duration, length, likes) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $insertPostStmt = $conn->prepare($insertPostQuery);
  if ($insertPostStmt === false) {
    die('Prepare failed for post insertion: ' . $conn->error);
  }

  // Binding dei parametri per l'inserimento del post
  $insertPostStmt->bind_param('issssdi', $user_id, $title, $location, $activity, $duration, $length, $likes);

  // Esecuzione della query per l'inserimento del post
  if ($insertPostStmt->execute()) {
    // Ottieni l'ID dell'ultimo inserimento
    $post_id = $insertPostStmt->insert_id;
    $_SESSION['post_id'] = $post_id;

    // Inserimento dei waypoints con un'unica query
    $insertWaypointsQuery = "INSERT INTO waypoints (post_id, coordinates, km) VALUES (?, ?, ?), (?, ?, ?)";
    $insertWaypointsStmt = $conn->prepare($insertWaypointsQuery);
    if ($insertWaypointsStmt === false) {
      die('Prepare failed for waypoints insertion: ' . $conn->error);
    }

    // Binding dei parametri per l'inserimento dei waypoints
    $insertWaypointsStmt->bind_param('isiisd', $post_id, $origin, $originKm, $post_id, $destination, $destinationKm);

    // Esecuzione della query per l'inserimento dei waypoints
    if ($insertWaypointsStmt->execute()) {
      // Reindirizzamento alla pagina di controllo dopo l'inserimento
      header("Location: ./../public/check.php");
      exit();
    } else {
      // Gestione dell'errore
      error_log("Errore nell'inserimento dei waypoints: " . $insertWaypointsStmt->error);
    }
  } else {
    // Gestione dell'errore
    error_log("Errore nell'inserimento del post: " . $insertPostStmt->error);
  }
} else {
  echo "Metodo di richiesta non valido.";
}
