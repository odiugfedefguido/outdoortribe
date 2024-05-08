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
 
  <link rel="stylesheet" href="./styles/followed.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main>
  <?php 

$current_user_id = isset($_GET['follower_id']) ? $_GET['follower_id'] : null; // Recupera l'ID dell'utente dall'URL

if($current_user_id !== null) {
    //query per ottenere i follower
    $query = "SELECT user.name, user.surname, user.id
          FROM user
          JOIN follow ON user.id = follow.follower_id
          WHERE follow.followed_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    //stampo il nuemro di follower
    echo '<h1>Followers</h1>';
    echo '<p>Number of followers: '.$result->num_rows.'</p>';

    //stampo i follower
    while($row = $result->fetch_assoc()) {
        $follower_id = $row['id'];
        $follower_name = $row['name'];
        $follower_surname = $row['surname'];
        //query per ottenere l'immagine del follower
        $query_image = "SELECT name
            FROM photo
            WHERE user_id = ? AND post_id IS NULL";

        $stmt_image = $conn->prepare($query_image);
        $stmt_image->bind_param("i", $follower_id);
        $stmt_image->execute();
        $result_image = $stmt_image->get_result();
        
        // Controllo se esiste un'immagine per il follower
        if ($result_image->num_rows > 0) {
            $photo_profile_row = $result_image->fetch_assoc();
            $follower_image = "./../uploads/photos/profile/" . $photo_profile_row['name'];
        } else {
            // Se non c'è un'immagine per il follower, utilizzo un'immagine predefinita o mostro un messaggio
            $follower_image = "default_profile_image.jpg"; // Immagine predefinita
        }

        //stampo la foto del follower
        echo '<div class="follower">';
        echo '<img class="circular-square-img" src="'.$follower_image.'" alt="profile picture">';
        echo '<a href="otherprofile.php?id='.$follower_id.'" class="profile-link">'.$follower_name.' '.$follower_surname.'</a>';
                    
        echo '<a href="profilepage.php?id='.$follower_id.'" class="view-profile-button full-btn">View profile</a>';
        echo '</div>';
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
