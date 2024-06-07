<?php
session_start();
include("../server/connection.php");
include("functions.php");

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodifica il JSON inviato e ottieni i dati
    $data = json_decode(file_get_contents("php://input"), true);
    $post_id = $data['post_id']; // Recupera post_id dai dati inviati
    $user_id = $_SESSION['user_id'];
    
    $new_rating = filter_var($data['rating'], FILTER_VALIDATE_INT);

    if ($new_rating === false) {
        $response["message"] = "Rating is not valid!";
        echo json_encode($response);
        exit();
    }

    $new_rating = mysqli_real_escape_string($conn, $new_rating);
    $resultRating = checkRating($conn, $post_id, $user_id);

    if ($resultRating->num_rows > 0) {
        if (updateRating($conn, $post_id, $user_id, $new_rating)) {
            $response["rating_updated"] = true;
        } else {
            $response["rating_updated"] = false;
        }
    } else {
        if (insertRating($conn, $post_id, $user_id, $new_rating)) {
            $response["rating_inserted"] = true;
        } else {
            $response["rating_inserted"] = false;
        }
    }

    $response["success"] = true;
    $response["message"] = "Operation completed";
} else {
    $response["message"] = "Invalid session data!";
}

echo json_encode($response);
$conn->close();