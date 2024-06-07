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
  <title>Followers</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./styles/follower.css">
  <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
  <link rel="stylesheet" href="./../templates/components/components.css"> <!-- Aggiunto il link al file CSS dei componenti -->
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

    // Stampa il numero di follower
    echo '<h1>Followers</h1>';
    echo '<p>Number of followers: '.$result->num_rows.'</p>';

    // Stampa i follower
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
        
        // Ottieni il nome dell'immagine del follower o usa un'icona predefinita se non è disponibile
        $photo_profile_row = $result_image->fetch_assoc();
        $follower_image = !empty($photo_profile_row['name']) ? "./../uploads/photos/profile/" . $photo_profile_row['name'] : "./../assets/icons/profile.svg";


        // Verifica se l'utente loggato segue già l'utente visualizzato
        $query_check_follow = "SELECT * FROM follow WHERE follower_id = ? AND followed_id = ?";
        $stmt_check_follow = $conn->prepare($query_check_follow);
        $stmt_check_follow->bind_param("ii", $log_user_id, $follower_id);
        $stmt_check_follow->execute();
        $result_check_follow = $stmt_check_follow->get_result();
        $is_following = $result_check_follow->num_rows > 0;

        // Stampa l'immagine e il pulsante follow/unfollow per il follower
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
  <!-- Script JavaScript per gestire il follow/unfollow -->
  <script src="./../public/javascript/follow.js"></script>
    

</body>
</html>
