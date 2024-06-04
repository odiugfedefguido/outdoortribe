<?php

session_start();

include("./../server/connection.php");
include("./../admin/functions.php");

/*
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ./../login.php");
    exit;
}*/

$user_id= 10; //$_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifiche</title>
    <link rel="stylesheet" href="notification.css">
</head>
<body>



        
<main>
    <?php
    $query = "SELECT notifications.*, user.name AS source_name, user.surname AS source_surname
    FROM notifications
    INNER JOIN user ON notifications.user_id = user.id
    WHERE notifications.source_user_id = ?
    ORDER BY notifications.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);


//query per ottenere il nome dell'utente
$query_user = "SELECT name, surname
FROM user
WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$stmt->close();
$conn->close();

foreach ($notifications as $notification) {
    echo "Notifica ID: " . $notification['id'] . "<br>";
    echo "Tipo: " . $notification['type'] . "<br>";
    echo "Destinatario: " . $notification['source_name'] . " " . $notification['source_surname'] . "<br>";
    echo "Data: " . $notification['created_at'] . "<br><br>";
}    ?>
    </main>
    <div class="container">
            <h1>Notifiche di <?php echo $user['name'] . " " . $user['surname']; ?></h1>
        </div>
</body>
</html>
