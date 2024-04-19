<?php
  session_start();
  include ("./../server/connection.php");
  include ("./../server/functions.php");
  
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
  <link rel="stylesheet" href="./styles/homepage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include('./../templates/header.html'); ?>
<main>
  <div class="post-container">
    <div class="username-container">
      <img class="user-picture" src="./../assets/icons/profile.svg" alt="username-picture">
      <p class="username">Mario Rossi</p>
    </div>
    <div class="photo-container">
      <div class="map">
        <img src="./../assets/icons/map.svg" alt="post-picture">
      </div>
      <div class="user-photos">
        <img src="./../assets/photos/explorer.svg" alt="">
        <img src="./../assets/photos/landscape.svg" alt="">
      </div>
    </div>
    <div class="info-container">
      <div class="title">
        <h2>Questo è il titolo del post</h2>
      </div>
      <div class="location">
        <img src="./../assets/icons/location.svg" alt="location-icon">
        <p>Location</p>
      </div>
      <div class="activity">
        <img src="./../assets/icons/activity.svg" alt="activity-icon">
        <p>Attività</p>
      </div>
      <div class="details-countainer">
        <div class="duration">
          <img src="./../assets/icons/time.svg" alt="duration-activity-icon">
          <p>Duration</p>
        </div>
        <div class="length">
          <img src="./../assets/icons/length.svg" alt="length-activity-icon">
          <p>Km:12</p>
        </div>
        <div class="altitude">
          <img src="./../assets/icons/altitude.svg" alt="altitude-activity-icon">
          <p>Altitudine</p>
        </div>
        <div class="difficulty-easy">
          <p>Difficulty</p>
        </div>
      </div>
      <div class="rating-likes">
        <div class="rating">
          <img src="./../assets/icons/star.svg" alt="rating-icon">
        </div>
        <div class="likes">
          <img src="./../assets/icons/like.svg" alt="like-icon">
        </div>
      </div>
    </div>

    <?php
      // // Assicurati di avere l'ID dell'utente corrente (supponiamo sia 1 per esempio)
      // $current_user_id = 1;

      // // Query per ottenere i post delle persone che segui
      // $query = "SELECT p.title, p.content 
      //           FROM posts p 
      //           INNER JOIN follows f ON p.user_id = f.followed_id 
      //           WHERE f.follower_id = $current_user_id";
      // $result = $conn->query($query);

      // // Mostra i post
      // if ($result->num_rows > 0) {
      //     while($row = $result->fetch_assoc()) {
      //         echo "<div class='post'>";
      //         echo "<h2>" . $row["title"] . "</h2>";
      //         echo "<p>" . $row["content"] . "</p>";
      //         echo "</div>";
      //     }
      // } else {
      //     echo "Nessun post disponibile";
      // }
      // $conn->close();
    ?>
  </div>
</main>

<?php include('./../templates/footer.html'); ?>
</body>
</html>