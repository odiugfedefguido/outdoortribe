<?php
session_start();
include ("../server/connection.php");
include("functions.php");

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents("php://input"), true);
    
    $new_rating = filter_var($data['rating'], FILTER_VALIDATE_INT);
    $difficulty = ucfirst(filter_var($data['difficulty'], FILTER_SANITIZE_SPECIAL_CHARS));

    if ($new_rating === false || $difficulty === false) {
        $response["message"] = "Rating or difficulty are not valid!";
        echo json_encode($response);
        exit();
    }

    // Ottieni il rating attuale per il post e l'utente
    $resultRating = checkRating($conn, $post_id, $user_id);
    $current_rating = 0;
    $num_rows = 0;
    
    // Calcola la media del rating attuale
    if ($resultRating->num_rows > 0) {
        while ($row = $resultRating->fetch_assoc()) {
            $current_rating += $row['rating'];
            $num_rows++;
        }
        $current_rating /= $num_rows;
    }

    // Calcola il nuovo rating come media tra il rating attuale e il nuovo rating
    $updated_rating = ($current_rating * $num_rows + $new_rating) / ($num_rows + 1);

    // Aggiorna il rating nel database
    if ($num_rows > 0) {
        $response["rating_updated"] = updateRating($conn, $post_id, $user_id, $updated_rating);
    } else {
        $response["rating_inserted"] = insertRating($conn, $post_id, $user_id, $updated_rating);
    }

    // Inserisci o aggiorna anche la difficoltà del post per l'utente
    $response["difficulty_inserted"] = insertDifficulty($conn, $post_id, $user_id, $difficulty);

    $response["success"] = true;
    $response["message"] = "Operation completed";
} else {
    $response["message"] = "Invalid session data!";
}

echo json_encode($response);
$conn->close();
?>