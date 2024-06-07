<?php
// Avvia la sessione
session_start();
include("./../server/connection.php");

$response = ['success' => false, 'message' => ''];

if (isset($_SESSION['user_id']) && isset($_POST['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];

    // Prepare and execute the insert query
    $stmt = $conn->prepare("INSERT INTO shared_post (user_id, post_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $post_id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Database error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request.";
}

header('Content-Type: application/json');
echo json_encode($response);

// Log per vedere la risposta generata
error_log(json_encode($response));
?>
