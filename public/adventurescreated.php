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
  <title>Adventurers Created</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../templates/post/post.css">
  <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
 
  <!-- Collegamento al font Roboto -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <!-- Inclusione della libreria jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main>
  <?php 

$current_user_id = 1; //$_SESSION['user_id'];

//query per ottenere i post dell'utente
$query = "SELECT post.title, post.location, post.user_id, post.duration, post.length, post.max_altitude, post.difficulty
      FROM post
      WHERE post.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

//query per ottenere il nome e il cognome dell'utente
$query_user = "SELECT name, surname
          FROM user
          WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $current_user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();


//stampo il numero di post creati
echo '<h1>Posts created</h1>';
echo '<p>Number of posts created: '.$result->num_rows.'</p>';

//stampo i post creati
if($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //recuperra l'url dell'immagine del profilo, il rating medio del post e i nomi degli utenti che hanno messo like
    $profile_photo_url = getProfilePhotoUrl($conn, $row['user_id']);
    $average_rating = getAverageRating($conn, $row['user_id']);
    list($full_stars, $half_star) = getStars($average_rating);
    

    $post_id = $row['id'];
    $username = $user['name'] . ' ' . $user['surname'];
    $title = $row['title'];
    $location = $row['location'];
    $activity = $row['activity'];
    
    $duration = $row['duration'];
    $length = $row['length'];
    $altitude = $row['max_altitude'];
    $difficulty = $row['difficulty'];
    
    
    
   // $rating = $average_rating;
    $likes = $row['likes'];
    $is_post_details = false;
    //$like_icon_class = $row['user_liked'] ? 'like-icon liked' : 'like-icon';


    /*//query per ottenere l'immagine del post
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
        // Se non c'è un'immagine per il post, utilizzo un'immagine predefinita
        $photo_url = "./../assets/icons/post.svg";
    }

    




    echo '<div class="adventure">';
    echo '<img src="'.$photo_url.'" alt="Post image">';
    // Aggiungi un link attorno al titolo dell'avventura
    echo '<h2><a href="post_details.php?post_id='.$post_id.'">'.$post_title.'</a></h2>';
    echo '<p>'.$post_location.'</p>';
    echo '<p>'.$post_duration.'</p>';
    echo '<p>'.$post_km.'</p>';
    echo '<p>'.$post_elevation.'</p>';
    echo '<p>'.$post_difficulty.'</p>';
    
    

    echo '</div>';
}*/

  include ('./../templates/post/post.php');
}
} else {
    echo "No posts available";
}

$conn->close();
?>


  </main>
  <?php include("./../templates/footer/footer.html"); ?>
</body>

</html>