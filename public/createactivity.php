<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

$_SESSION['post_created'] = false;
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  echo "<script>console.log('User ID: $user_id');</script>";
} else {
  // Se l'utente non è loggato, reindirizza alla pagina di login o mostra un messaggio di errore
  header("Location: login.php");
  exit();
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
  <link rel="stylesheet" href="styles/createactivity.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css" type="text/css">
  <title>Create New Activity</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <div class="title-container">
      <h1>Create a new Activity</h1>
    </div>
    <form id="check-form" action="./../admin/post_creation.php" method="post">
      <div class="form-container">
        <div class="location-container">
          <div class="text-container">
            Post Title 
          </div>
            <label class="label-hidden" for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Title" required>
        </div>
        <div class="location-container">
          <div class="text-container">
            Which Location?
          </div>
            <label class="label-hidden" for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Location" required>
        </div>
        <div class="activity-container">
          <div class="text-container">
            Which Activity?
          </div>
            <label class="label-hidden" for="activity-type">Type of Activity</label>
            <select id="activity-type" name="activity" required>
              <option value="" disabled selected hidden>Activity</option>
              <option value="cycling">Cycling</option>
              <option value="trekking">Trekking</option>
              <option value="hiking">Hiking</option> 
            </select>
        </div>
      </div>
    </form>
    <div class="message-container">
      <p>Please, enter waypoints</p>
    </div>
    <div id="map-id">
    </div>
    <div class="buttons-container">
      <button id="check-btn" name="check-btn" type="submit">Check</button>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>

  <script src="./javascript/createactivity.js"></script>
  </body>
</html>