    // Seleziona tutte le immagini con la classe 'clickable-image'
    var immagini = document.querySelectorAll('.clickable-image');

    // Aggiungi un gestore di eventi a ciascuna immagine
    immagini.forEach(function(immagine) {
      immagine.addEventListener('click', function() {
        // Mostra il popup
        document.querySelector('.popup-image').style.display = 'block';
        // Imposta l'immagine ingrandita nel popup
        document.getElementById('popupImg').src = immagine.src;
        event.stopPropagation();
      });
    });

    // Seleziona il popup e il body del documento
    var popup = document.querySelector('.popup-image');
    var body = document.body;

    // Aggiungi un gestore di eventi per il click al body del documento
    body.addEventListener('click', function(event) {
      // Verifica se l'elemento cliccato non è il popup o un suo figlio
      if (event.target !== popup && !popup.contains(event.target)) {
        // Chiudi il popup
        popup.style.display = 'none';
      }
    });