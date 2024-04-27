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
    <div class="back">
      <img src="./../assets/icons/back-icon.svg" alt="">
    </div>
    <?php
    if (isset($_GET['id'])) {
      $post_id = $_GET['id'];

      $query_post = "SELECT * FROM post WHERE id = $post_id";
      $result = $conn->query($query_post);

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
      } else {
        echo "Post non trovato.";
      }
    ?>

    <?php
    echo $post_id;
    $waypoints_query = "SELECT * FROM waypoints WHERE post_id = $post_id";
    $waypoints_result = $conn->query($waypoints_query);
    ?>
    <div class="waypoints-container">
      <img src="./../assets/icons/waypoints.svg" alt="route-icon">
      <h2>Waypoints</h2>
      <?php
      if ($waypoints_result->num_rows > 0) {
        // Se ci sono dei waypoints, cicla su di essi e visualizzali
        while ($waypoint = $waypoints_result->fetch_assoc()) {
      ?>
      <div class="waypoints">
        <div class="waipoints-1">
          <div class="icon"><img src="./../assets/icons/location.svg" alt=""></div>
          <div class="number"><?php echo $waypoint['km']; ?></div>
        </div>
        <div class="waypoints-2">
          <h2><?php echo $waypoint['title']; ?></h2>
          <div class="description"><?php echo $waypoint['description']; ?></div>
        </div>
      </div>
      <?php
        }
      } else {
        // Se non ci sono waypoints per il post corrente, visualizza un messaggio
        echo "Nessun waypoint trovato per questo post.";
      }
    ?>
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
              <img src="./../uploads/photos/post/adventure1.png" alt="Post Image">
              <img src="./../uploads/photos/post/adventure2.png" alt="Post Image">
              <img src="./../uploads/photos/post/adventure3.png" alt="Post Image">
              <img src="./../uploads/photos/post/adventure4.png" alt="Post Image">
              <div class="view-all-container">
                <h2 class="view-all"><a href="#"></a>View All</h2>
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
      echo "ID del post non specificato.";
    }
    ?>
  </main>
  <?php include("./../templates/footer.html");?>
</body>
</html>