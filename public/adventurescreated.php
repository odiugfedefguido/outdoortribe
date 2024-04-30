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
    <title>My Website</title>
    <link rel="stylesheet" href="./../templates/styles/header.css">
    <link rel="stylesheet" href="./../templates/styles/footer.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../public/styles/adventure.css">
    
</head>
<body>
    <?php include ('./../templates/header/header.html'); ?>

    <!-- Contenuto della pagina -->
    <main>
        <?php 

        $current_user_id = 1; //$_SESSION['user_id'];
       
       //query per ottenere i post dell'utente
        $query = "SELECT post.title, post.location, post.id
              FROM post
              WHERE post.user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        //stampo il numero di post creati
        echo '<h1>Posts created</h1>';
        echo '<p>Number of posts created: '.$result->num_rows.'</p>';

        //stampo i post creati
        while($row = $result->fetch_assoc()) {
            $post_id = $row['id'];
            $post_title = $row['title'];
            $post_location = $row['location'];
            //query per ottenere l'immagine del post
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
            echo '<h2>'.$post_title.'</h2>';
            echo '<p>'.$post_location.'</p>';
            echo '</div>';
        }

        $conn->close();
        ?>
    </main>

    <?php include ('./../templates/footer/footer.html'); ?>
</body>
</html>
