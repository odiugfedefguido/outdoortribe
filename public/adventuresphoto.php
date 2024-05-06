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
  <title>Photos</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
 
  <link rel="stylesheet" href="./styles/photo.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main class="photo-grid">
    <?php

    $current_user_id = 1; //$_SESSION['user_id'];

    
     //query per ottenere le foto condivise dall'utente
        $query = "SELECT photo.name, post.title, post.location, post.id
                FROM photo
                JOIN post ON photo.post_id = post.id
                WHERE photo.user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        //stampo il numero di foto condivise
        echo '<h1>Photos shared</h1>';
        echo '<p>Number of photos shared: ' . $result->num_rows . '</p>';

        //stampo le foto condivise
        while ($row = $result->fetch_assoc()) {
            $photo_name = $row['name'];

            $post_id = $row['id'];
            echo '<div class="photo">';
            echo '<img src="./../uploads/photos/post/' . $photo_name . '" alt="' . $photo_name . '">';
            
            echo '</div>';
            echo '</div>';
        }

        
    
   


    ?>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
</body>

</html>