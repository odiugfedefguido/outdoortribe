<?php
session_start();
include ("../server/connection.php");
include("functions.php");

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_SESSION['post_id'];
    $user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents("php://input"), true);
    
    $rating = filter_var($data['rating'], FILTER_VALIDATE_INT);
    $difficulty = ucfirst(filter_var($data['difficulty'], FILTER_SANITIZE_SPECIAL_CHARS));

    if ($rating === false || $difficulty === false) {
        $response["message"] = "Rating or difficulty are not valid!";
        echo json_encode($response);
        exit();
    }

    $rating = mysqli_real_escape_string($conn, $rating);
    $difficulty = mysqli_real_escape_string($conn, $difficulty);
    $resultRating = checkRating($conn, $post_id, $user_id);

    if ($resultRating->num_rows > 0) {
        if (updateRating($conn, $post_id, $user_id, $rating)) {
            $response["rating_updated"] = true;
        } else {
            $response["rating_updated"] = false;
        }
    } else {
        if (insertRating($conn, $post_id, $user_id, $rating)) {
            $response["rating_inserted"] = true;
        } else {
            $response["rating_inserted"] = false;
        }
    }

    if (insertDifficulty($conn, $post_id, $user_id, $difficulty)) {
        $response["difficulty_inserted"] = true;
    } else {
        $response["difficulty_inserted"] = false;
    }

    $response["success"] = true;
    $response["message"] = "Operation completed";
} else {
    $response["message"] = "Invalid session data!";
}

echo json_encode($response);
$conn->close();