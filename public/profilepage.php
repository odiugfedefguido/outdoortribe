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
               <button class="check-btn" type="submit">ciao amiciaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</button>
               <button class="check-btn" type="submit">Check 2</button>
            </div>
                
        </main>

        


    <?php include ('./../templates/footer.html'); ?>

</body>
</html>

