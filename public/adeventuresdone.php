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
  <title>Post Details</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
 
  <link rel="stylesheet" href="./styles/done.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main>
    <?php

    $current_user_id = 1; //$_SESSION['user_id'];

    //query per ottenere gli shared post
    $query = "SELECT post.title, post.location, post.id
              FROM post
              JOIN shared_post ON post.id = shared_post.post_id
              WHERE shared_post.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    //stampo il numero di post condivisi
    echo '<h1>Posts shared</h1>';
    echo '<p>Number of posts shared: ' . $result->num_rows . '</p>';

    //stampo i post condivisi
    while ($row = $result->fetch_assoc()) {
      $post_id = $row['id'];
      $post_title = $row['title'];
      $post_location = $row['location'];
      //query per ottenere l'immagine del post
      $query_image = "SELECT name
                      FROM photo
                      WHERE user_id = ? AND post_id = ?";
      $stmt_image = $conn->prepare($query_image);
      $stmt_image->bind_param("ii", $current_user_id, $post_id);
      $stmt_image->execute();
      $result_image = $stmt_image->get_result();

      // Controllo se esiste un'immagine per il post
      if ($result_image->num_rows > 0) {
        $photo_profile_row = $result_image->fetch_assoc();
        $photo_url = "./../uploads/photos/post/" . $photo_profile_row['name'];
      } else {
        $photo_url = "./../uploads/photos/post/default.jpg";
      }

      echo '<div class="post">';
      echo '<img src="' . $photo_url . '" alt="Post image">';
      echo '<div class="post-info">';
      echo '<h2>' . $post_title . '</h2>';
      echo '<p>' . $post_location . '</p>';
      echo '</div>';
      echo '</div>';
    }
    
   


    ?>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
</body>

</html>