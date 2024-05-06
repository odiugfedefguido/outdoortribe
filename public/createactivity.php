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
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
   crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
   integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
   crossorigin=""></script>
  <title>Create New Activity</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <div class="title-container">
      <h1>Create a new Activity</h1>
    </div>
    <form id="check-form" action="check.php" method="post">
    <div class="form-container">
        <div class="location-container">
          <div class="text-container">
            Which Activity?
          </div>
            <label class="label-hidden" for="location">Location</label>
            <input type="text" id="location" placeholder="Location">
        </div>
        <div class="activity-container">
          <div class="text-container">
            Which Activity?
          </div>
            <label class="label-hidden" for="activity-type">Type of Activity</label>
            <select name="activity-type" id="activity-type" required>
              <option value="" disabled selected hidden>Activity</option>
              <option value="cycling">Cycling</option>
              <option value="trekking">Trekking</option>
              <option value="hiking">Hiking</option> 
            </select>
        </div>
    </div>
    </form>
    <div class="message-container">
      <p>Please, enter coordinates</p>
    </div>
    <div id="map-id">
      
    </div>
    <div class="buttons-container">
      <button id="check-btn" type="submit">Check</button>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>

  <script src="./javascript/createactivity.js"></script>
  </body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map-id').setView([51.505, -0.09], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
});
</script>

