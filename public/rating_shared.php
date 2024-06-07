<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");


if (isset($_SESSION['user_id'])) {
  $post_id = $_GET['post_id'];
  $user_id = $_SESSION['user_id'];
  echo "<script>console.log('Post ID: $post_id');</script>";
  echo "<script>console.log('User ID: $user_id');</script>";
} else {
  header("Location: ./login.php");
}
?>
<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="/outdoortribe/templates/footer/footer.css">
  <link rel="stylesheet" href="/outdoortribe/templates/header/header.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="stylesheet" href="styles/rating.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Rating</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <div class="upper-container">
      <div class="back-btn-container">
        <a href="./photo_upload.php" class="back-button">
          <img class="back-icon" src="/outdoortribe/assets/icons/back-icon.svg" alt="back-icon">
        </a>
      </div>
      <div class="title-container">
        <h1>Almost There!</h1>
      </div>
    </div>
    <div class="rating-wrapper">
      <h2>Rate the route!</h2>
      <div class="ratings">
        <span class="star">&#9733</span>
        <span class="star">&#9733</span>
        <span class="star">&#9733</span>
        <span class="star">&#9733</span>
        <span class="star">&#9733</span>
      </div>
    </div>
    <div class="buttons-container">
        <button class="full-btn" id="submit-rating">Create Activity</button>
      </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script src="./javascript/shared_rating.js"></script>
</body>
</html>