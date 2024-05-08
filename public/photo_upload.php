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
        <a href="./check.php" class="back-button">
          <img class="back-icon" src="/outdoortribe/assets/icons/back-icon.svg" alt="back-icon">
        </a>
        <h1>Images</h1>
      </div>
      <div class="upload-container">
        <input type="file" id="file-input" onchange="preview()" multiple>
        <label for="file-input">
          Select Photos
        </label>
        <p id="num-files">No Files Chosen</p>
        <div id="images"></div>
      </div>
      <div class="buttons-container">
        <button class="full-btn" onclick="window.location.href = 'rating.php';">Next</button>
      </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script src="javascript/photo_upload.js"></script>
</body>
</html>