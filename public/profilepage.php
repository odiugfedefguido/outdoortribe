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
    <link rel="stylesheet" href="./../public/styles/profilepage.css">
</head>
<body>
    <?php include ('./../templates/header.html'); ?>

    <!-- Contenuto della pagina -->
    <main>
        <?php 

        $current_user_id = 5; //$_SESSION['user_id'];


        //query per ottenere il nome della persona
        $query_search = "SELECT user.name, user.surname 
              FROM user
              WHERE user.id = ?";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $name = $row['name'];
        $surname = $row['surname'];

        //query per ottenere il numero di follower
        $query_search = "SELECT COUNT(follower_id) as followers
              FROM follow
              WHERE follow.followed_id = ?";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $followers = $row['followers'];

        //query per ottenere il numero di persone seguite
        $query_search = "SELECT COUNT(followed_id) as followed
              FROM follow
              WHERE follow.follower_id = ?";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $followed = $row['followed'];






        $conn->close();
        ?>
        <div class="profile-container">
            <div class="circular-square">
                <img class="circular-square-img" src="./../uploads/photos/profile/man1.png" alt="immagine Profilo"/>
                <button class="profile-icon-button" type="button"></button>
            </div>
            
        </div>
        <p class="profile-name"><?php echo $name . " " . $surname; ?></p>
        <div class="buttons-container">
            <div class="button-column">
                <button class="check-btn" type="submit"><?php echo $followers; ?> FOLLOWERS</button>
            </div>
            <div class="button-column">
                <button class="check-btn" type="submit"><?php echo $followed; ?> FOLLOWING</button>
            </div>
        </div>

        <div class="word-font">Adventures</div>
        <div class="empty-buttons-container"> 
            <button class="empty-check-btn" type="submit">Done</button>
            <button class="empty-check-btn" type="submit">Liked</button>
            <button class="empty-check-btn" type="submit">Created</button>
        </div>

        <div class="word-font">Media</div>
        <div class="empty-buttons-container"> 
            <button class="empty-check-btn" type="submit">Your photos</button>
        </div>

    </main>

    <?php include ('./../templates/footer.html'); ?>
</body>
</html>
