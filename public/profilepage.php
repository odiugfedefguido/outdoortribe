<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Controllo se l'utente è autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
} else {
    header("Location: ./login.php");
    exit();
}

//$current_user_id= 1;

// Esegui le query per ottenere i dati dell'utente
$stmt = $conn->prepare("SELECT name, surname, 
    (SELECT COUNT(follower_id) FROM follow WHERE followed_id = ?) AS followers, 
    (SELECT COUNT(followed_id) FROM follow WHERE follower_id = ?) AS followed, 
    (SELECT name FROM photo WHERE user_id = ? AND post_id IS NULL) AS profile_photo 
    FROM user WHERE id = ?");
$stmt->bind_param("iiii", $current_user_id, $current_user_id, $current_user_id, $current_user_id);
$stmt->execute();
$stmt->bind_result($name, $surname, $followers, $followed, $profile_photo);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="./../templates/header/header.css">
    <link rel="stylesheet" href="./../templates/footer/footer.css">
    <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
    <link rel="stylesheet" href="./styles/profilepage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include("./../templates/header/header.html"); ?>
    <main>
        <?php

        $current_user_id = $_SESSION['user_id']; //Sostituire con $_SESSION['user_id']

        ?>
        <div class="profile-container">
            <div class="circular-square">
                <?php if (!empty($profile_photo)) { ?>
                    <img class="circular-square-img" src="./../uploads/photos/profile/<?php echo $profile_photo; ?>" alt="profile-photo">
                <?php } else { ?>
                    <div class="user-picture"></div>
                <?php } ?>
            </div>
        </div>
        <form action="./../public/upload_profile_photo.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="file-input" name="image" accept=".jpg, .jpeg, .png" style="display:none;">
            <button id="upload-button" type="button">Change Photo</button>
            <button type="submit" style="display:none;" id="submit-button"></button>
        </form>
        <div id="images"></div>

        <p class="profile-name"><?php echo $name . " " . $surname; ?></p>
        <div class="buttons-container">
            <div class="button-column">
                <form action="./../public/followers.php" method="get">
                    <input type="hidden" name="follower_id" value="<?php echo $current_user_id; ?>">
                    <button class="check-btn" type="submit"><?php echo $followers; ?> FOLLOWERS</button>
                </form>
            </div>
            <div class="button-column">
                <form action="./../public/follow.php" method="get">
                    <input type="hidden" name="followed_id" value="<?php echo $current_user_id; ?>">
                    <button class="check-btn" type="submit"><?php echo $followed; ?> FOLLOWED</button>
                </form>
            </div>
        </div>
        <div class="word-font">Adventures</div>
        <div class="empty-buttons-container">
            <form action="./../public/adventuresdone.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Done</button>
            </form>
            <form action="./../public/adventuresliked.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Liked</button>
            </form>
            <form action="./../public/adventurescreated.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Created</button>
            </form>
        </div>
        <div class="word-font">Media</div>
        <div class="empty-buttons-container">
            <form action="./../public/adventuresphoto.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Photos</button>
            </form>
        </div>
    </main>
    <?php include("./../templates/footer/footer.html"); ?>
    <script>
        document.getElementById("upload-button").addEventListener("click", function() {
            document.getElementById("file-input").click();
        });

        document.getElementById("file-input").addEventListener("change", function() {
            document.getElementById("submit-button").click();
        });

        function preview() {
            let fileInput = document.getElementById("file-input");
            let imageContainer = document.getElementById("images");

            imageContainer.innerHTML = "";
            let files = fileInput.files;

            if (files.length > 0) {
                let reader = new FileReader();
                let figure = document.createElement("figure");
                let figCap = document.createElement("figcaption");
                figCap.innerText = files[0].name;
                figure.appendChild(figCap);

                reader.onload = () => {
                    let image = document.createElement("img");
                    image.className = "upload-image";
                    image.src = reader.result;
                    figure.insertBefore(image, figCap);
                }

                imageContainer.appendChild(figure);
                reader.readAsDataURL(files[0]);
            }
        }
    </script>
</body>
</html>
