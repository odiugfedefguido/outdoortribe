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
var map;
var markerMode = false;

var waypointControl = L.Control.extend({
  options: {
    position: 'topright' 
  },

  onAdd: function (map) {
    var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
    container.style.backgroundColor = 'white';
    container.style.display = 'flex';
    container.style.width = 'auto';
    container.style.height = '20px';
    container.style.cursor = 'pointer';

    // Creazione del testo del controllo
    var buttonText = L.DomUtil.create('div', 'leaflet-bar-part', container);
    buttonText.textContent = 'Waypoint';
    buttonText.style.fontSize = '12px';
    buttonText.style.fontWeight = 'bold';
    buttonText.style.textAlign = 'center';
    buttonText.style.padding = '0 2px 0 2px';

    // Gestione dell'evento click sul controllo
    L.DomEvent.addListener(container, 'click', function(e){
      L.DomEvent.stopPropagation(e);
      console.log('buttonClicked');
      toggleMarkerMode(); 
    });

    return container;
  },
});

function toggleMarkerMode() {
  markerMode = !markerMode; 
  if (markerMode) {
    map.getContainer().style.cursor = 'crosshair';
  } else {
    map.getContainer().style.cursor = '';
  }
}

document.addEventListener('DOMContentLoaded', function() {
    map = L.map('map-id').setView([51.505, -0.09], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      minZoom: 4,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    map.zoomControl.remove();

    var southWest = L.latLng(-90, -180);
    var northEast = L.latLng(90, 180);
    var bounds = L.latLngBounds(southWest, northEast);
    map.setMaxBounds(bounds);
    map.on('drag', function() {
        map.panInsideBounds(bounds, { animate: false });
    });

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            var accuracy = position.coords.accuracy;

            var circle = L.circle([lat, lon], {
                radius: accuracy,
                color: 'blue',
                fillColor: '#3186cc',
                fillOpacity: 0.2
            }).addTo(map);

            map.fitBounds(circle.getBounds());
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
    addMarkerOnClick(map);
    map.addControl(new waypointControl());
});

function addMarkerOnClick(map) {
    // Array per memorizzare i marker aggiunti
    var markers = [];

    // Aggiungi l'evento di click alla mappa solo se la modalità di inserimento è attiva
    map.on('click', function(event) {
        if (markerMode) {
          // Ottieni le coordinate del punto in cui è stato cliccato
          var lat = event.latlng.lat;
          var lon = event.latlng.lng;
          console.log(lat, lon);

          // Crea un nuovo marker e aggiungilo alla mappa
          var marker = L.marker([lat, lon]).addTo(map);

          // Aggiungi il marker all'array
          markers.push(marker);

          // Crea un popup con un pulsante "Elimina" e associalo al marker
          var popupContent = document.createElement('div');
          var deleteButton = document.createElement('button');
          deleteButton.textContent = 'Elimina';
          deleteButton.addEventListener('click', function() {
              // Rimuovi il marker dalla mappa
              map.removeLayer(marker);
              // Rimuovi il marker dall'array
              var index = markers.indexOf(marker);
              if (index !== -1) {
                  markers.splice(index, 1);
              }
          });
          popupContent.appendChild(deleteButton);
          marker.bindPopup(popupContent);
        }
    });
}
</script>

