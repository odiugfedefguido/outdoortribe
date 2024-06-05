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

  <!--Leaflet stylesheet and js inclusion -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    
  <!--Leaflet routing machine stylesheet and js inclusion-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

  <!--Geocoder stylesheet and js inclusion-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>
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