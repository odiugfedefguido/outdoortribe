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
        <div class="profile-container">
            <div class="circular-square">
                <img class="circular-square-img" src="./../uploads/photos/profile/man1.png" alt="immagine Profilo"/>
                <button class="profile-icon-button" type="button"></button>
            </div>
            
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
