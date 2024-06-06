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
      // Ottieni la prima rotta disponibile
      const route = e.route[0];
      
      // Distanza totale in chilometri
      const distanceInKm = route.distance / 1000;
      
      // Durata totale in minuti
      const durationInMinutes = route.duration / 60;
      
      console.log(`Distanza totale: ${distanceInKm.toFixed(2)} km`);

      if (durationInMinutes > 60) {
        const hours = Math.floor(durationInMinutes / 60);
        const minutes = Math.floor(durationInMinutes % 60);
        console.log(`Tempo totale: ${hours} ore e ${minutes} minuti`);
      } else {
        const totalMinutes = Math.floor(durationInMinutes);
        console.log(`Tempo totale: ${totalMinutes} minuti`);
      }
    }

    console.log(e.route[0].legs);
    destinationCoordinates = routingControl.getDestination().geometry.coordinates;
    originCoordinates = routingControl.getOrigin().geometry.coordinates;
    
    console.log('Your Destination ', destinationCoordinates);
    console.log('Your Origin ', originCoordinates);
  });
});