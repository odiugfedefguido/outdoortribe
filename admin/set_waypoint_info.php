<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database
include("./../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_SESSION['post_id'])) {
    die("Errore: post ID non trovato.");
  }

  $post_id = $_SESSION['post_id'];
  $titles = $_POST['title'];
  $descriptions = $_POST['description'];
  $coordinatesArray = $_POST['coordinates'];

  // Itera attraverso i waypoints e aggiorna il database
  foreach ($titles as $index => $title) {
    $description = $descriptions[$index];
    $coordinates = $coordinatesArray[$index];

    $updateWaypointQuery = "UPDATE waypoints SET title = ?, description = ? WHERE post_id = ? AND coordinates = ?";
    $updateWaypointStmt = $conn->prepare($updateWaypointQuery);
    if ($updateWaypointStmt === false) {
      die('Prepare failed for waypoints update: ' . $conn->error);
    }

    $updateWaypointStmt->bind_param('ssis', $title, $description, $post_id, $coordinates);
    if (!$updateWaypointStmt->execute()) {
      die('Execute failed for waypoints update: ' . $updateWaypointStmt->error);
    }
  }

  // Reindirizzamento dopo l'aggiornamento
  header("Location: ./../public/photo_upload.php");
  exit();
} else {
  echo "Metodo di richiesta non valido.";
}
