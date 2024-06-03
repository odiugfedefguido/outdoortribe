<?php
session_start();
include ("../server/connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $post_id = $_SESSION['post_id'];
  $user_id = $_SESSION['user_id'];
  $data = json_decode(file_get_contents("php://input"), true);
  
  $rating = filter_var($data['rating'], FILTER_VALIDATE_INT);
  $difficulty = filter_var($data['difficulty'], FILTER_SANITIZE_STRING);

  if ($rating === false || $difficulty === false) {
    echo json_encode(["success" => false, "message" => "Rating or difficulty are not valid!"]);
    exit();
  }

  $rating = mysqli_real_escape_string($conn, $rating);
  $difficulty = mysqli_real_escape_string($conn, $difficulty);
  $resultRating = checkRating($conn, $post_id, $user_id);

  if ($resultRating->num_rows > 0) {
    if (updateRating($conn, $post_id, $user_id, $rating)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "message" => "Failed to update rating!"]);
    }
  } else {
    if (insertRating($conn, $post_id, $user_id, $rating)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "message" => "Failed to insert rating!"]);
    }
  }

  if (insertDifficulty($conn, $post_id, $user_id, $difficulty)) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to insert difficulty!"]);
  }
  
} else {
  echo json_encode(["success" => false, "message" => "Invalid session data!"]);
}
$conn->close();