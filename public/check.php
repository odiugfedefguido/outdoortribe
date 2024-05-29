<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");
?>

<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="./styles/check.css">  
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Check</title>
</head>
  <body>
 <?php include ('./../templates/header/header.html'); ?>
  <main class="outer-flex-container">
  <div class="upper-container">
    <div class="back-btn-container">
      <a href="./createactivity.php" class="back-button">
        <img class="back-icon" src="/outdoortribe/assets/icons/back-icon.svg" alt="back-icon">
      </a>
    </div>
    <div class="title-container">
      <h1>Waypoints</h1>
    </div>
  </div>
    <div class="paragraph-400">
      <p>Have you encountered anything along the way that you shouldn't miss?</p>
      <p>Select the waypoints along the the route and give them a description</p>
    </div>
    <div class="image-container">
      <img src="../assets/icons/map.svg" alt="map">
    </div>
    <form class="form-container" action="photo_upload.php" method="post">
      <div class="inner-form-container">
        <div class="coords-container"> 
          <label class="label-hidden" for="coordinates">Coordinates</label>
          <input type="text" id="coordinates" placeholder="Coordinates">
        </div>
        <div class="text-container">
          <label class="label-hidden" for="landmark">Landmark</label>
          <input type="text" id="landmark" placeholder="What's there?">
          <label class="label-hidden" for="description">Description</label>
          <input type="text" id="description" placeholder="Description (optional)">
        </div>
      </div>
      <div class="buttons-container">
        <button class="full-btn">Next</button>
      </div>
    </form>
  </main>
</body>
</html>
