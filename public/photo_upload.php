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

if(isset($_GET['alert_message'])) {
  echo '<script>alert("' . $_GET['alert_message'] . '");</script>';
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
  <link rel="stylesheet" href="styles/photo_upload.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Images Upload</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
  <div class="upper-container">
    <div class="back-btn-container">
      <a href="./check.php" class="back-button">
        <img class="back-icon" src="/outdoortribe/assets/icons/back-icon.svg" alt="back-icon">
      </a>
    </div>
    <div class="title-container">
      <h1>Images</h1>
    </div>
  </div>
    <form class="upload-container" id="upload-form" action="./../admin/add_photo.php" method="post" enctype="multipart/form-data">
      <input type="file" id="file-input" onchange="preview()" name="images[]" multiple>
      <label for="file-input">
        Select Photos
      </label>
      <p id="num-files">No Files Chosen</p>
      <div id="images"></div>
      </div>
    </form>
    <div class="buttons-container">
      <button class="full-btn" id="full-btn" type="submit">Next</button>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script src="javascript/photo_upload.js"></script>
  <script>
    // DEBUG Stampa post_id e user_id nella console
    var postId = '<?php echo $post_id; ?>';
    console.log('Post ID:', postId);
    var userId = '<?php echo $user_id; ?>';
    console.log('User ID:', userId);
  </script>
</body>
</html>