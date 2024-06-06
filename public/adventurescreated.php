<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Verifica se l'utente è già autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
$user_data = checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventurers Created</title>
    <link rel="stylesheet" href="./../templates/header/header.css">
    <link rel="stylesheet" href="./../templates/footer/footer.css">
    <link rel="stylesheet" href="./../templates/post/post.css">
    <link rel="stylesheet" href="./styles/adventurescreated.css">
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

        $current_user_id = $_SESSION['user_id'];

        // Query per ottenere i post dell'utente
        $query = "SELECT post.id, post.title, post.location, post.user_id, post.duration, post.length, post.max_altitude, post.difficulty, post.activity, post.likes,
              (SELECT COUNT(*) FROM likes WHERE post_id = post.id AND user_id = ?) AS user_liked
          FROM post
          WHERE post.user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $current_user_id, $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Query per ottenere il nome e il cognome dell'utente
        $query_user = "SELECT name, surname FROM user WHERE id = ?";
        $stmt_user = $conn->prepare($query_user);
        $stmt_user->bind_param("i", $current_user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();

        // Stampare i post creati
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Recupera l'url dell'immagine del profilo, il rating medio del post e i nomi degli utenti che hanno messo like
                $profile_photo_url = getProfilePhotoUrl($conn, $row['user_id']);
                $average_rating = getAverageRating($conn, $row['id']);
                list($full_stars, $half_star) = getStars($average_rating);

                $user_id = ($row['user_id'] == $current_user_id) ? null : $row['user_id'];
                $post_id = $row['id'];
                $username = $user['name'] . ' ' . $user['surname'];
                $title = $row['title'];
                $location = $row['location'];
                $activity = $row['activity'];

                $duration = $row['duration'];
                $length = $row['length'];
                $altitude = $row['max_altitude'];
                $difficulty = $row['difficulty'];
                $likes = $row['likes'];
                $is_post_details = false;
                $like_icon_class = $row['user_liked'] ? 'like-icon liked' : 'like-icon';

                include('./../templates/post/post.php');
            }
        } else {
            echo "<h2>Non hai ancora creato nessuna avventura</h2>";
        }

        $conn->close();
        ?>
        <!-- Spazio vuoto per la formattazione -->
        <div class="empty-space"></div>

    </main>
    <?php include("./../templates/footer/footer.html"); ?>

    <script src="./../templates/post/post.js"></script>
</body>

</html>
