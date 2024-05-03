<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

//$user_data = checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searching</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../templates/post/post.css">
  <link rel="stylesheet" href="./styles/searching.css">
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

    if (isset($_GET['location']) && isset($_GET['activity'])) {
      // Recupera i valori della località e dell'attività
      $location = '%' . $_GET['location'] . '%';
      $activity = $_GET['activity'];

      // Query per ottenere i post 
      $query = "SELECT *
                FROM post
                WHERE location LIKE ? 
                AND activity = ?";

      // Prepara la query
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ss", $location, $activity);
      $stmt->execute();
      $post_result = $stmt->get_result();

      // Se ci sono, mostra i post in ordine cronologico
      if ($post_result->num_rows > 0) {
        while ($post = $post_result->fetch_assoc()) {

          $profile_photo_url = getProfilePhotoUrl($conn, $post['user_id']);

          $like_icon_class = getLike($conn, $post['id'], $current_user_id);

          $user_info = getUserInfo($conn, $post['user_id']);

          if ($user_info !== false) {
            $user = $user_info;
            
            $average_rating = getAverageRating($conn, $post['id']);
            list($full_stars, $half_star) = getStars($average_rating);

            $post_id = $post['id'];
            $username = $user['name'] . ' ' . $user['surname'];
            $title = $post['title'];
            $location = $post['location'];
            $activity = $post['activity'];
            $duration = $post['duration'];
            $length = $post['length'];
            $altitude = $post['max_altitude'];
            $difficulty = $post['difficulty'];
            $rating = $average_rating;
            $likes = $post['likes'];
            $is_post_details = false;

            include('./../templates/post/post.php');
          } else {
            echo "Errore: Impossibile trovare l'utente con ID " . $user_id;
          }
        }
      } else {
        echo "Nessun post disponibile";
      }
    }
    $conn->close();
    ?>
    <div class="empty-space"></div>
  </main>
  <?php include('./../templates/footer/footer.html'); ?>

  <script src="./../templates/post/post.js"></script>
</body>

</html>