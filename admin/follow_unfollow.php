<?php
session_start();
include("./../server/connection.php");

$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;
$followed_id = isset($_POST['followed_id']) ? intval($_POST['followed_id']) : null;

if ($current_user_id && $followed_id && $action) {
  if ($action === 'follow') {
    $query = "INSERT INTO follow (follower_id, followed_id) VALUES (?, ?)";
  } else if ($action === 'unfollow') {
    $query = "DELETE FROM follow WHERE follower_id = ? AND followed_id = ?";
  }

  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $current_user_id, $followed_id);

  if ($stmt->execute()) {
    echo 'success';
  } else {
    echo 'error';
  }

  $stmt->close();
}

$conn->close();
?>
