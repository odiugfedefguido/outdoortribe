document.addEventListener("DOMContentLoaded", function() {
  const checkBtn = document.getElementById("check-btn");
  const checkForm = document.getElementById("check-form");

  checkBtn.addEventListener("click", function(event) {
    event.preventDefault();
    if (checkForm.checkValidity()) {
      checkForm.submit();
    } else {
      checkForm.reportValidity();
    }
  });
});
// Map initialization settings
const ZOOM_LEVEL = 18;
const INITIAL_LAT = 44.14;
const INITIAL_LNG = 12.23;

// Create the map and set its view to the specified latitude, longitude, and zoom level
const map = L.map("map-id").setView([INITIAL_LAT, INITIAL_LNG], ZOOM_LEVEL);

// Add Mapbox tile layer to the map
const mapboxLayer = L.tileLayer('https://api.mapbox.com/styles/v1/sdamn1234/clw65nd8l01gi01quawexh6fd/tiles/512/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoic2RhbW4xMjM0IiwiYSI6ImNsdzdycm81bzIweDUyaG11eHl6bDVpd2IifQ.RZ09JtF323GUF-tUIeLJ8g', {
  minZoom: 7,
  maxZoom: 18,
  attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>'
}).addTo(map);

// Initialize routing control
const routingControl = L.Routing.control({
  waypoints: [],
  routeWhileDragging: true,
  geocoder: L.Control.Geocoder.nominatim()
}).addTo(map);

// Variables to store the distance and duration
let routeDistance = 0;
let routeDuration = 0;

// Event listener for when a route is found
routingControl.on('routesfound', function(e) {
  const routes = e.routes;
  const summary = routes[0].summary;

  // Save the distance and duration in variables
  routeDistance = summary.totalDistance;
  routeDuration = summary.totalTime;

  console.log('Distance:', routeDistance, 'meters');
  console.log('Duration:', routeDuration, 'seconds');
});

// Function to create a button
function createButton(label, className, container) {
  const button = L.DomUtil.create('button', 'full-btn', container);
  button.setAttribute('type', 'button');
  button.innerHTML = label;
  return button;
}

// Function to handle adding waypoints and displaying the popup with options
function onMapClick(e) {
  const container = L.DomUtil.create('div');
  const startButton = createButton('Start from this location', 'full-btn', container);
  const destButton = createButton('Go to this location', 'full-btn', container);

  // Display the popup with start and destination buttons at the clicked location
  L.popup()
    .setContent(container)
    .setLatLng(e.latlng)
    .openOn(map);

  // Event listener for "Start from this location" button click
  L.DomEvent.on(startButton, 'click', function() {
    routingControl.spliceWaypoints(0, 1, e.latlng); // Set the start waypoint
    map.closePopup(); // Close the popup
  });

  // Event listener for "Go to this location" button click
  L.DomEvent.on(destButton, 'click', function() {
    routingControl.spliceWaypoints(routingControl.getWaypoints().length - 1, 1, e.latlng); // Set the destination waypoint
    map.closePopup(); // Close the popup
  });
}

// Attach the click event listener to the map
map.on('click', onMapClick);
