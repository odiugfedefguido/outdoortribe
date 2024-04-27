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
  <link rel="stylesheet" href="./../templates/styles/header.css">
  <link rel="stylesheet" href="./../templates/styles/footer.css">
  <link rel="stylesheet" href="./../templates/styles/components.css">
  <link rel="stylesheet" href="./../templates/styles/post.css">
  <link rel="stylesheet" href="./styles/post_details.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header.html");?>
  <main>
    <?php
    if (isset($_GET['id'])) {
      $post_id = $_GET['id'];

      $query = "SELECT * FROM post WHERE id = $post_id";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();

        $user_query = "SELECT name, surname FROM user WHERE id = " . $post['user_id'];
        $user_result = $conn->query($user_query);

        $title = $post['title'];
        $location = $post['location'];
        $activity = $post['activity'];
        $duration = $post['duration'];
        $length = $post['length'];
        $altitude = $post['altitude'];
        $difficulty = $post['difficulty'];
        $rating = $post['rating'];
        $likes = $post['likes'];
        $is_post_details = true;

        include("./../templates/post.php");
    ?>
        <div class="waypoints-container">
          <img src="./../assets/icons/waypoints.svg" alt="route-icon">
          <h2>Waypoints</h2>
          <div class="waypoints">
            <div class="waipoints-1">
              <div class="icon"><img src="./../assets/icons/location.svg" alt=""></div>
              <div class="number">Numero</div>
            </div>
            <div class="waypoints-2">
              <h2>Titolo</h2>
              <div class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo nihil recusandae nostrum reprehenderit incidunt sint non, voluptatem temporibus. Doloremque, expedita quas tempore voluptate iusto facilis nihil alias qui possimus quo?</div>
            </div>
          </div>
        </div>
        
        <div class="technical-data">
          <h2>Technical Data</h2>
          <div class="grid-data">
            <div class="level">
              <p class="paragraph-450">Level:</p>
              <p class="paragraph-400">Lorem </p>
            </div>
            <div class="length">
              <p class="paragraph-450">Length:</p>
              <p class="paragraph-400">Lorem </p>
            </div>
            <div class="ascent">
              <p class="paragraph-450">Total ascent:</p>
              <p class="paragraph-400">Lorem </p>
            </div>
            <div class="descent">
              <p class="paragraph-450">Total descent:</p>
              <p class="paragraph-400">Lorem </p>
            </div>
            <div class="max-altitude">
              <p class="paragraph-450">Max altitude:</p>
              <p class="paragraph-400">Lorem </p>
            </div>
            <div class="min-altitude">
              <p class="paragraph-450">Min altitude:</p>
              <p class="paragraph-400">Lorem </p>
            </div>
          </div>
        </div>

        <div class="images">
          <h2>Images</h2>
          <div class="image-scroll-container">
            <div class="image-container">
              <img src="./../assets/photos/post/adventure1.png" alt="Post Image">
              <img src="./../assets/photos/post/adventure2.png" alt="Post Image">
              <img src="./../assets/photos/post/adventure3.png" alt="Post Image">
              <img src="./../assets/photos/post/adventure4.png" alt="Post Image">
              <!-- <a href="tutte_le_immagini.html" class="view-all">View All</a> -->
              <div class="view-all-container">
                <h2 class="view-all"><a href="tutte_le_immagini.html"></a>View All</h2>
              </div>
            </div>
          </div>
        </div>

        <div class="share">
          <h2>Have you done this activity?</h2>
          <p class="paragraph-400">Add it to your activities and share it with your friends!</p>
          <input class="full-btn" type="button" value="Add and Share">
        </div>
      <?php
      } else {
        echo "Post non trovato.";
      }
    } else {
      echo "ID del post non specificato.";
    }
      ?>
  </main>
  <?php include("./../templates/footer.html");?>
</body>
</html>