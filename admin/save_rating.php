<?php
session_start();
include ("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $post_id = $_SESSION['post_id'];
  $user_id = $_SESSION['user_id'];
  $data = json_decode(file_get_contents("php://input"), true);
  
  // Validazione del rating
  $rating = filter_var($data['rating'], FILTER_VALIDATE_INT);

  if ($rating === false) {
    echo json_encode(["success" => false, "message" => "Il rating non è valido!"]);
    exit();
  }

  // Sanitizzazione del rating
  $rating = mysqli_real_escape_string($conn, $rating);

  // Controllo se esiste già un record con lo stesso post_id e user_id
  $checkQuery = "SELECT * FROM post_ratings WHERE post_id = ? AND user_id = ?";
  $checkStmt = $conn->prepare($checkQuery);
  $checkStmt->bind_param('ii', $post_id, $user_id);
  $checkStmt->execute();
  $result = $checkStmt->get_result();

  if ($result->num_rows > 0) {
    // Se il record esiste, esegui un UPDATE
    $updateQuery = "UPDATE post_ratings SET rating = ?, created_at = NOW() WHERE post_id = ? AND user_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('iii', $rating, $post_id, $user_id);
    if ($updateStmt->execute()) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "message" => "Non è stato possibile aggiornare il rating!"]);
    }
  } else {
    // Se il record non esiste, esegui un INSERT
    $insertQuery = "INSERT INTO post_ratings (post_id, user_id, rating, created_at) VALUES (?, ?, ?, NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param('iii', $post_id, $user_id, $rating);
    if ($insertStmt->execute()) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "message" => "Il caricamento del rating non è andato a buon fine!"]);
    }
  }
}
$conn->close();