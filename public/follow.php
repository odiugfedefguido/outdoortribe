<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

//$user_data = check_login($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Followers</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./styles/follower.css">
  <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main class="container">
  <?php 
$log_user_id = 6; //$_SESSION['user_id'];
$current_user_id = isset($_GET['followed_id']) ? $_GET['followed_id'] : null; // Recupera l'ID dell'utente dall'URL

if($current_user_id !== null) {
    //query per ottenere i followed
    $query = "SELECT user.name, user.surname, user.id
          FROM user
          JOIN follow ON user.id = follow.followed_id
          WHERE follow.follower_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    //stampo il nuemro di followed
    echo '<h1>Followed</h1>';
    echo '<p>Number of followed: '.$result->num_rows.'</p>';

    //stampo i followed
    while($row = $result->fetch_assoc()) {
      $followed_id = $row['id'];
      $followed_name = $row['name'];
      $followed_surname = $row['surname'];

      
      // Query per ottenere l'immagine del followed
      $query_image = "SELECT name
          FROM photo
          WHERE user_id = ? AND post_id IS NULL";
      
      // Esegui la query per ottenere l'immagine del followed
      $stmt_image = $conn->prepare($query_image);
      $stmt_image->bind_param("i", $followed_id);
      $stmt_image->execute();
      $result_image = $stmt_image->get_result();
  
      // Controllo se esiste un'immagine per il followed
      if ($result_image->num_rows > 0) {
          $photo_profile_row = $result_image->fetch_assoc();
          $followed_image = "./../uploads/photos/profile/" . $photo_profile_row['name'];
      } else {
          // Se non c'è un'immagine per il followed, utilizzo un'immagine predefinita o mostro un messaggio
          $followed_image = "default_profile_image.jpg"; // Immagine predefinita
      }
  
      //stampo la foto del followed
      echo '<div class="follower">';
      echo '<img class="profile-picture" src="'.$followed_image.'" alt="profile picture">';
      echo '<div class="follower-info">';
      echo '<a href="otherprofile.php?id='.$followed_id.'" class="profile-link">'.$followed_name.' '.$followed_surname.'</a>';
      echo '<a href="javascript:void(0)" class="view-profile-button unfollow-button" data-followed-id="' . $followed_id . '">Unfollow</a>';
      echo '</div>';
      echo '</div>';
      echo '<hr>';
  }  
     

} else {
    echo '<p>No user ID provided.</p>';
}

$conn->close();
?>

  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  
  
</body>

</html>
