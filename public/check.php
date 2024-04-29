<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="./styles/check.css">
  <link rel="stylesheet" href="/outdoortribe/templates/header/header.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Check</title>
</head>
<body>
  <header>
    <div class="left-section">
      <img class="logo" src="./../assets/icons/logo.svg" alt="Logo - OutdoorTribe">
  </div>
    <div class="right-section">
      <button class="menu-button">
        <img class="menu-icon" src="/outdoortribe/assets/icons/optionsMenu.svg" alt="menu-icon">
      </button>
    </div>
  </header>
  <main class="outer-flex-container">
    <div class="title-container">
      <h1>Waypoints</h1>
    </div>
    <button class="back-button">
      <img class="back-icon" src="/outdoortribe/assets/icons/back-icon.svg" alt="back-icon">
    </button>
    <div class="message container">
      <p>Have you encountered anything along the way that you shouldn't miss?</p>
      <p>Select the waypoints along the the route and give them a description</p>
    </div>
    <div class="image-container">
      <img src="../assets/icons/map.svg" alt="map">
    </div>
    <form action="" method="post">
      <div class="form-container">
        <label class="label-hidden" for="coordinates">Coordinates</label>
        <input type="text" id="coordinates" placeholder="Coordinates" required>
        <label class="label-hidden" for="landmark">Landmark</label>
        <input type="text" id="landmark" placeholder="What's there?" required>
        <label class="label-hidden" for="description">Description</label>
        <input type="text" id="description" placeholder="Description (optional)">
      </div>
      <div class="buttons-container">
        <button id="next-btn">Next</button>
      </div>
    </form>
  </main>
</body>
</html>

<?php 
include ('./../templates/header.html'); 
?>