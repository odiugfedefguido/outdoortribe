<?php
session_start(); // Avvia la sessione

include("./../server/connection.php"); // Includi il file di connessione al database
include("./../admin/functions.php"); // Includi il file delle funzioni ausiliarie

// Ottieni l'ID dell'utente loggato, se non è presente usa un valore predefinito (6)
$log_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 6;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Followed</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./styles/follower.css">
  <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Passa l'ID dell'utente loggato a JavaScript -->
  <script>
    var loggedUserId = <?php echo $log_user_id; ?>;
  </script>
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main class="container">
  <?php 
  // Recupera l'ID dell'utente seguito dall'URL
  $current_user_id = isset($_GET['followed_id']) ? $_GET['followed_id'] : null;

  if ($current_user_id !== null) {
      // Query per ottenere gli utenti seguiti
      $query = "SELECT user.name, user.surname, user.id
                FROM user
                JOIN follow ON user.id = follow.followed_id
                WHERE follow.follower_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $current_user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      // Stampa il numero di utenti seguiti
      echo '<h1>Followed</h1>';
      echo '<p>Number of followed: '.$result->num_rows.'</p>';

      // Stampa gli utenti seguiti
      while ($row = $result->fetch_assoc()) {
        $followed_id = $row['id'];
        $followed_name = $row['name'];
        $followed_surname = $row['surname'];

        // Query per ottenere l'immagine del profilo dell'utente seguito
        $query_image = "SELECT name FROM photo WHERE user_id = ? AND post_id IS NULL";
        $stmt_image = $conn->prepare($query_image);
        $stmt_image->bind_param("i", $followed_id);
        $stmt_image->execute();
        $result_image = $stmt_image->get_result();

        // Ottieni il nome dell'immagine del profilo o usa un'icona predefinita se non è disponibile
        $photo_profile_row = $result_image->fetch_assoc();
        $followed_image = !empty($photo_profile_row['name']) ? "./../uploads/photos/profile/" . $photo_profile_row['name'] : "./../assets/icons/profile.svg";

        // Verifica se l'utente loggato segue già l'utente visualizzato
        $query_check_follow = "SELECT * FROM follow WHERE follower_id = ? AND followed_id = ?";
        $stmt_check_follow = $conn->prepare($query_check_follow);
        $stmt_check_follow->bind_param("ii", $log_user_id, $followed_id);
        $stmt_check_follow->execute();
        $result_check_follow = $stmt_check_follow->get_result();
        $is_following = $result_check_follow->num_rows > 0;

        // Stampa l'immagine e il pulsante di follow/unfollow per l'utente seguito
        echo '<div class="follower">';
        echo '<img style="background-color: black;"class="profile-picture" src="'.$followed_image.'" alt="profile picture">';
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
  <script src="./../public/javascript/follow.js"></script>
  
</body>
</html>
