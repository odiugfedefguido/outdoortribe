// Seleziona tutte le immagini con la classe 'clickable-image'
var immagini = document.querySelectorAll('.clickable-image');

// Aggiungi un gestore di eventi a ciascuna immagine
immagini.forEach(function (immagine) {
  immagine.addEventListener('click', function () {
    // Mostra il popup quando si clicca sull'immagine
    document.querySelector('.popup-image').style.display = 'block';
    // Imposta l'immagine ingrandita nel popup con lo stesso URL dell'immagine cliccata
    document.getElementById('popupImg').src = immagine.src;
    event.stopPropagation(); // Blocca la propagazione dell'evento di click per evitare che venga catturato dal gestore di eventi del body
  });
});

// Seleziona il popup e il body del documento
var popup = document.querySelector('.popup-image');
var body = document.body;

// Aggiungi un gestore di eventi per il click al body del documento
body.addEventListener('click', function (event) {
  // Verifica se l'elemento cliccato non è il popup o un suo figlio
  if (event.target !== popup && !popup.contains(event.target)) {
    // Chiudi il popup se si clicca al di fuori di esso
    popup.style.display = 'none';
  }
});
