<?php
include("./../server/connection.php");

if (isset($_POST['follower_id']) && isset($_POST['followed_id'])) {
    $follower_id = $_POST['follower_id'];
    $followed_id = $_POST['followed_id'];

    // Query to delete the follow record
    $query = "DELETE FROM follow WHERE follower_id = ? AND followed_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $follower_id, $followed_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'failure';
    }

    $stmt->close();
}

$conn->close();
?>
