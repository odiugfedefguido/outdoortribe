document.addEventListener('DOMContentLoaded', function() {
  document.addEventListener('click', function(event) {
    // Verifica se l'elemento cliccato è un'icona del like
    if (event.target.classList.contains('like-icon')) {
      // Toggle tra l'icona di like e l'icona di like cliccato
      event.target.classList.toggle('liked');
    }
  });
});