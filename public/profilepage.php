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
    <!-- Includi lo stile CSS qui -->
    <link rel="stylesheet" href="./../templates/styles/header.css">
    <link rel="stylesheet" href="./../templates/styles/footer.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!--css della pagina-->
    <link rel="stylesheet" href="./../public/styles/profilepage.css">

    <!--api-->

</head>
<body>

    <?php include ('./../templates/header.html'); ?>

        <!-- Contenuto della pagina -->
        <main>
            <div class="circular-square">
            <img class="circular-square circular-square img" src="./../uploads/photos/profile/man1.png" alt="immagine Profilo"/>
            </div>

            <p class="profile-name">Mario Rossi</p>

            <div class="buttons-container">
                <div class="button-column">
                    <button class="check-btn" type="submit">225 FOLLOWER</button>
                </div>
                <div class="button-column">
                    <button class="check-btn" type="submit">234 FOLLOWED</button>
                </div>
            </div>

            <p class="word-font">Adventures</p>
            <div class="empty-buttons-container"> 
                <button class="empty-check-btn" type="submit">Done</button>
                <button class="empty-check-btn" type="submit">Liked</button>
                <button class="empty-check-btn" type="submit">Created</button>
            </div>

            <p class="word-font">Media</p>
            <div class="empty-buttons-container"> 
                <button class="empty-check-btn" type="submit">Yout photos</button>
            </div>

</div>



         
    </div>
                
        </main>

        


    <?php include ('./../templates/footer.html'); ?>

</body>
</html>

