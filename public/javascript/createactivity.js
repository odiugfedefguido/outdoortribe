let distanceInKm;
let formattedDuration;
let durationInSeconds;
let originString;
let destinationString;
let originKm;
let destinationKm;

document.addEventListener("DOMContentLoaded", function() {
  const checkBtn = document.getElementById("check-btn");
  const checkForm = document.getElementById("check-form");

  checkBtn.addEventListener("click", function(event) {
    event.preventDefault();
    if (checkForm.checkValidity()) {
      inviaDatiModuloConDistanza();
    } else {
      checkForm.reportValidity();
    }
  });
});

function inviaDatiModuloConDistanza() {
  const checkForm = document.getElementById("check-form");

  // Creare un oggetto FormData con i dati del modulo
  const formData = new FormData(checkForm);
  formData.append('distance', distanceInKm.toFixed(2));
  formData.append('duration', formattedDuration);
  formData.append('origin', originString);
  formData.append('destination', destinationString);
  formData.append('originKm', originKm);
  formData.append('destinationKm', destinationKm);

  // Creare e inviare la richiesta AJAX
  const xhr = new XMLHttpRequest();
  const url = "./../admin/post_creation.php";
  xhr.open("POST", url, true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      console.log("Richiesta completata con successo.");
      // Reindirizzamento alla pagina di controllo dopo l'inserimento
      window.location.href = "./../public/check.php";
    } else {
      console.error("Si è verificato un errore durante la richiesta.");
      console.log(xhr.responseText); // Log della risposta del server
    }
  };
  xhr.onerror = function() {
    console.error("Si è verificato un errore durante la richiesta.");
  };
  xhr.send(formData);
}



// Map initialization settings
const ZOOM_LEVEL = 14;
const INITIAL_LAT = 44.14;
const INITIAL_LNG = 12.23;
mapboxgl.accessToken = 'pk.eyJ1Ijoic2RhbW4xMjM0IiwiYSI6ImNsdzUyajZwZTFxaGQybHFzeXg4OGdrMmIifQ.lhP_TVQsdKncEHBYTh3NHA';

const map = new mapboxgl.Map({
  container: 'map-id',
  style: 'mapbox://styles/sdamn1234/clw65nd8l01gi01quawexh6fd',
  center: [INITIAL_LNG, INITIAL_LAT],
  zoom: ZOOM_LEVEL
}).addControl(new mapboxgl.NavigationControl(), 'top-left');

const routingControl = new MapboxDirections({
  accessToken: mapboxgl.accessToken,
  unit: 'metric',
  profile: 'mapbox/walking',
  steps: true,
  waypoints: [],
  controls: {
    inputs: true,
    instructions: true,
    profileSwitcher: true
  },
  profiles: ['mapbox/walking', 'mapbox/cycling'],
});

map.addControl(routingControl, 'top-right');

map.on('load', function() {
  routingControl.on('route', function(e) {
    console.log(e); // Logs the current route shown in the interface.

    if (e.route && e.route.length > 0) {
      const route = e.route[0];
      distanceInKm = parseFloat(route.distance / 1000);
      durationInSeconds = route.duration;

      // Converti la durata totale in ore, minuti e secondi
      const hours = Math.floor(durationInSeconds / 3600);
      const minutes = Math.floor((durationInSeconds % 3600) / 60);
      const seconds = Math.floor(durationInSeconds % 60);
      formattedDuration = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`; 

      originString = `Lat: ${routingControl.getOrigin().geometry.coordinates[1].toFixed(6)} Long: ${routingControl.getOrigin().geometry.coordinates[0].toFixed(6)}`;
      destinationString = `Lat: ${routingControl.getDestination().geometry.coordinates[1].toFixed(6)} Long: ${routingControl.getDestination().geometry.coordinates[0].toFixed(6)}`;

      originKm = 0;
      destinationKm = distanceInKm.toFixed(2);
    }
  });
});