<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

// $user_data = check_login($conn);
$log_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 6; // Sostituisci con $_SESSION['user_id'] in produzione
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
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main>
  <?php 

$current_user_id = isset($_GET['follower_id']) ? $_GET['follower_id'] : null; // Recupera l'ID dell'utente dall'URL

if($current_user_id !== null) {
    // Query per ottenere i follower
    $query = "SELECT user.name, user.surname, user.id
          FROM user
          JOIN follow ON user.id = follow.follower_id
          WHERE follow.followed_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Stampo il numero di follower
    echo '<h1>Followers</h1>';
    echo '<p>Number of followers: '.$result->num_rows.'</p>';

    // Stampo i follower
    while($row = $result->fetch_assoc()) {
        $follower_id = $row['id'];
        $follower_name = $row['name'];
        $follower_surname = $row['surname'];
        // Query per ottenere l'immagine del follower
        $query_image = "SELECT name
            FROM photo
            WHERE user_id = ? AND post_id IS NULL";

        $stmt_image = $conn->prepare($query_image);
        $stmt_image->bind_param("i", $follower_id);
        $stmt_image->execute();
        $result_image = $stmt_image->get_result();
        
        // Controllo se esiste un'immagine per il follower
        $photo_profile_row = $result_image->fetch_assoc();
        $followed_image = !empty($photo_profile_row['name']) ? "./../uploads/photos/profile/" . $photo_profile_row['name'] : "./../assets/icons/profile.svg";


        // Controllo se l'utente loggato segue già l'utente visualizzato
        $query_check_follow = "SELECT * FROM follow WHERE follower_id = ? AND followed_id = ?";
        $stmt_check_follow = $conn->prepare($query_check_follow);
        $stmt_check_follow->bind_param("ii", $log_user_id, $follower_id);
        $stmt_check_follow->execute();
        $result_check_follow = $stmt_check_follow->get_result();
        $is_following = $result_check_follow->num_rows > 0;

        // Stampo la foto del follower e il pulsante follow/unfollow
        echo '<div class="follower">';
        echo '<img style="background-color: black;" class="profile-picture" src="'.$follower_image.'" alt="profile picture">';
        echo '<div class="follower-info">';
        echo '<a href="otherprofile.php?id='.$follower_id.'" class="profile-link">'.$follower_name.' '.$follower_surname.'</a>';
        echo '<a href="#" class="follow-btn" data-id="'.$follower_id.'">'.($is_following ? 'Unfollow' : 'Follow').'</a>';
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var followButtons = document.querySelectorAll('.follow-btn');
      followButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.preventDefault();
          var followedId = this.getAttribute('data-id');
          var action = this.innerText === 'Follow' ? 'follow' : 'unfollow';
          
          fetch('./../admin/follow_unfollow.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=' + action + '&followed_id=' + followedId
          })
          .then(response => response.text())
          .then(data => {
            if (data === 'success') {
              location.reload();
            } else {
              alert('Error: ' + data);
            }
          });
        });
      });
    });
  </script>
</body>
</html>
