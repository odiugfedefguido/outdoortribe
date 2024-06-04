<?php
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");


// Verifica se l'utente è già autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
$user_data = checkLogin($conn);
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="notification.css">
    <link rel="stylesheet" href="./../templates/header/header.css">
    <link rel="stylesheet" href="./../templates/footer/footer.css">
    <link rel="stylesheet" href="./../templates/post/post.css">
    <link rel="stylesheet" href="./styles/notification.css">
    <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">

    <!-- Collegamento al font Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Inclusione della libreria jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <?php include("./../templates/header/header.html"); ?>

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
        $stmt->close();

        // Query per ottenere il nome e il cognome dell'utente
        $query_user = "SELECT name, surname FROM user WHERE id = ?";
        $stmt_user = $conn->prepare($query_user);
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();
        $stmt_user->close();

        // Controlla se l'utente esiste
        if (!$user) {
            echo "Utente non trovato.";
            exit;
        }

        // Stampa il nome dell'utente
        echo "<div class='container'>";
        echo "<h1>Notifiche di " . htmlspecialchars($user['name']) . " " . htmlspecialchars($user['surname']) . "</h1>";
        echo "</div>";

        foreach ($notifications as $notification) {
            // Query per ottenere l'immagine della notifica
            $query_image = "SELECT name FROM photo WHERE user_id = ? AND post_id IS NULL";
            $stmt_image = $conn->prepare($query_image);
            $stmt_image->bind_param("i", $notification['user_id']);
            $stmt_image->execute();
            $result_image = $stmt_image->get_result();
            $photo = $result_image->fetch_assoc();
            $stmt_image->close();

            // Controlla se esiste l'immagine della notifica
            if ($photo) {
                $photo_url = "./../uploads/photos/profile/" . htmlspecialchars($photo['name']);
            } else {
                $photo_url = "default_profile_image.jpg"; // Immagine predefinita
            }

            // Stampa la notifica
            echo "<div class='notification'>";
            echo "<img class='profile-picture' src='" . $photo_url . "' alt='profile picture'>";
            echo "<div class='notification-text'>";
           
            echo '<a href="otherprofile.php?id=' . htmlspecialchars($notification['user_id']) . '" class="profile-link">' . htmlspecialchars($notification['source_name']) . " " . htmlspecialchars($notification['source_surname']) . "</a> ";
            if ($notification['type'] == 'follow') {
                echo "started following you";
            } elseif ($notification['type'] == 'like') {
                echo "likes your post";
            } elseif ($notification['type'] == 'trail') {
                echo "has done the trail you made";
            }
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }

        $conn->close();
        ?>

    </main>

    <?php include("./../templates/footer/footer.html"); ?>
</body>

</html>