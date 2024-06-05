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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    var loggedUserId = <?php echo $log_user_id; ?>;
  </script>
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main class="container">
  <?php 
  $current_user_id = isset($_GET['followed_id']) ? $_GET['followed_id'] : null; // Recupera l'ID dell'utente dall'URL

  if ($current_user_id !== null) {
      // Query per ottenere i followed
      $query = "SELECT user.name, user.surname, user.id
                FROM user
                JOIN follow ON user.id = follow.followed_id
                WHERE follow.follower_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $current_user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      // Stampo il numero di followed
      echo '<h1>Followed</h1>';
      echo '<p>Number of followed: '.$result->num_rows.'</p>';

      // Stampo i followed
      while ($row = $result->fetch_assoc()) {
        $followed_id = $row['id'];
        $followed_name = $row['name'];
        $followed_surname = $row['surname'];

        // Query per ottenere l'immagine del followed
        $query_image = "SELECT name FROM photo WHERE user_id = ? AND post_id IS NULL";
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
            $followed_image = "./../uploads/photos/profile/default_profile_image.jpg"; // Immagine predefinita
        }

        // Controllo se l'utente loggato segue già l'utente visualizzato
        $query_check_follow = "SELECT * FROM follow WHERE follower_id = ? AND followed_id = ?";
        $stmt_check_follow = $conn->prepare($query_check_follow);
        $stmt_check_follow->bind_param("ii", $log_user_id, $followed_id);
        $stmt_check_follow->execute();
        $result_check_follow = $stmt_check_follow->get_result();
        $is_following = $result_check_follow->num_rows > 0;

        // Stampo la foto del followed e il pulsante follow/unfollow
        echo '<div class="follower">';
        echo '<img class="profile-picture" src="'.$followed_image.'" alt="profile picture">';
        echo '<div class="follower-info">';
        echo '<a href="otherprofile.php?id='.$followed_id.'" class="profile-link">'.$followed_name.' '.$followed_surname.'</a>';
        echo '<a href="#" class="follow-btn" data-id="'.$followed_id.'">'.($is_following ? 'Unfollow' : 'Follow').'</a>';
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
