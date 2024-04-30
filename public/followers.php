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
    <link rel="stylesheet" href="./../public/styles/profilepage.css"> <!-- Rimuovi questo -->
    <link rel="stylesheet" href="styles.css"> <!-- Aggiungi questo -->
</head>
<body>
    <?php include ('./../templates/header/header.html'); ?>

    <!-- Contenuto della pagina -->
    <main>
        <?php 

        $current_user_id = 7; //$_SESSION['user_id'];
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
            echo '<div class="follower">';
            echo '<span>'.$follower_name.' '.$follower_surname.'</span>';
            echo '<a href="profilepage.php?id='.$follower_id.'">View profile</a>';
            echo '</div>';
        }


    








        $conn->close();
        ?>
    
    </main>

    <?php include ('./../templates/footer/footer.html'); ?>
</body>
</html>
