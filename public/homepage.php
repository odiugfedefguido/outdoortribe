<?php
session_start();
include("./../server/connection.php");
include("./../server/functions.php");

//$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomePage</title>
  <link rel="stylesheet" href="./../templates/styles/header.css">
  <link rel="stylesheet" href="./../templates/styles/footer.css">
  <link rel="stylesheet" href="./../templates/styles/post.css">
  <link rel="stylesheet" href="./styles/homepage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include('./../templates/header.html'); ?>
  <main>
    <?php

    $current_user_id = 5; //$_SESSION['user_id'];

    // Query per ottenere i post delle persone che l'utente segue
    $query_search = "SELECT post.*, user.name, user.surname 
          FROM post
          INNER JOIN follow ON post.user_id = follow.followed_id
          INNER JOIN user ON post.user_id = user.id
          WHERE follow.follower_id = ?
          ORDER BY post.created_at DESC";

    $stmt = $conn->prepare($query_search);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result_search = $stmt->get_result();

    // Se ci sono, mostra i post in ordine cronologico
    if ($result_search->num_rows > 0) {
      while ($row = $result_search->fetch_assoc()) {
        $query_photo_profile = "SELECT name FROM photo WHERE user_id = $row[user_id] AND post_id IS NULL";
        $result_photo_profile = $conn->query($query_photo_profile);

        // Verifica se c'è una foto del profilo associata all'utente che ha creato il post
        if ($result_photo_profile->num_rows > 0) {
          $photo_profile_row = $result_photo_profile->fetch_assoc();
          $profile_photo_url = "./../uploads/photos/profile/" . $photo_profile_row['name'];
        } else {
          // Se non c'è una foto del profilo associata all'utente, utilizza un'immagine predefinita
          $profile_photo_url = "./../assets/icons/profile.svg";
        }
        // Passa le variabili al template
        $post_id = $row['id'];
        $username = $row['name'] . ' ' . $row['surname'];
        $title = $row['title'];
        $location = $row['location'];
        $activity = $row['activity'];
        $duration = $row['duration'];
        $length = $row['length'];
        $altitude = $row['altitude'];
        $difficulty = $row['difficulty'];
        $rating = $row['rating'];
        $likes = $row['likes'];
        $is_post_details = false;
        include ('./../templates/post.php');
      }
    } else {
      echo "Nessun post disponibile";
    }
    $conn->close();
    ?>
    <div class="empty-space"></div>
  </main>

  <?php include('./../templates/footer.html'); ?>
</body>

</html>