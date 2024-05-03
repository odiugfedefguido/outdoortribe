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
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../templates/post/post.css">
  <link rel="stylesheet" href="./styles/homepage.css">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <?php include('./../templates/header/header.html'); ?>
  <main>
    <?php

    $current_user_id = 5; //$_SESSION['user_id'];

    // Query per ottenere i post delle persone che l'utente segue
    $query_search = "SELECT post.*, user.name, user.surname,
                (SELECT COUNT(*) FROM likes WHERE post_id = post.id AND user_id = ?) AS user_liked
                FROM post
                INNER JOIN follow ON post.user_id = follow.followed_id
                INNER JOIN user ON post.user_id = user.id
                WHERE follow.follower_id = ?
                ORDER BY post.created_at DESC";

    $stmt = $conn->prepare($query_search);
    $stmt->bind_param("ii", $current_user_id, $current_user_id);
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

        $post_id = $row['id'];
        // Aggiungi una query per calcolare la media dei rating per il post corrente
        $query_average_rating = "SELECT AVG(rating) AS average_rating FROM post_ratings WHERE post_id = ?";
        $stmt_avg_rating = $conn->prepare($query_average_rating);
        $stmt_avg_rating->bind_param("i", $post_id);
        $stmt_avg_rating->execute();
        $result_avg_rating = $stmt_avg_rating->get_result();

        // Estrai la media dei rating
        $average_rating_row = $result_avg_rating->fetch_assoc();
        $average_rating = $average_rating_row['average_rating'];

        // Gestisci il caso in cui non ci siano valutazioni per il post
        if ($average_rating === null) {
          $average_rating = 0; // Imposta il rating medio a 0 se non ci sono valutazioni
        }
        $full_stars = floor($average_rating); // Numero di stelle piene (parte intera)
        $half_star = round($average_rating - $full_stars); // Controllo se c'è una mezza stella
        
        // Passa le variabili al template
        $username = $row['name'] . ' ' . $row['surname'];
        $title = $row['title'];
        $location = $row['location'];
        $activity = $row['activity'];
        $duration = $row['duration'];
        $length = $row['length'];
        $altitude = $row['max_altitude'];
        $difficulty = $row['difficulty'];
        $rating = $average_rating;
        $likes = $row['likes'];
        $is_post_details = false;
        $like_icon_class = $row['user_liked'] ? 'like-icon liked' : 'like-icon';
        include('./../templates/post/post.php');
      }
    } else {
      echo "Nessun post disponibile";
    }
    $conn->close();
    ?>
    <div class="empty-space"></div>
  </main>

  <div class="popup" id="like-popup">
    <h2>Likes</h2>
    <ul id="likes-list">
      <!-- Qui verranno inseriti dinamicamente i nomi degli utenti che hanno messo like -->
    </ul>
  </div>

  <?php include('./../templates/footer/footer.html'); ?>

  <script src="./../templates/post/post.js"></script>

  <script src="./javascript//popup-likes.js"></script>

</body>

</html>