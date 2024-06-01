<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

if (isset($_SESSION['post_id']) && isset($_SESSION['user_id'])) {
  $post_id = $_SESSION['post_id'];
  $user_id = $_SESSION['user_id'];
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
      <div class="difficulty-wrapper">
        <h2>Choose difficulty!</h2>
        <div class="difficulty-options-container">
          <div class="option-container easy-container">
            <label for="difficulty-easy">Easy</label>
            <input type="radio" id="difficulty-easy" name="difficulty" value="easy">
          </div>
          <div class="option-container medium-container">
            <label for="difficulty-medium">Medium</label>
            <input type="radio" id="difficulty-medium" name="difficulty" value="medium">
          </div>
          <div class="option-container hard-container">
            <label for="difficulty-hard">Hard</label>
            <input type="radio" id="difficulty-hard" name="difficulty" value="hard">
          </div>
        </div>
      </div>
    </div>
    <div class="buttons-container">
        <button class="full-btn" id="submit-rating">Create Activity</button>
      </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script src="./javascript/rating.js"></script>
  <script>
    // DEBUG Stampa post_id e user_id nella console
    var post_id = '<?php echo $post_id; ?>';
    console.log('Post ID:', post_id);
    var user_id = '<?php echo $user_id; ?>';
    console.log('User ID:', user_id);
  </script>
</body>
</html>