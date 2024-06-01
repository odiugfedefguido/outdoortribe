/* Aggiunge un attributo "selected" all'elemento span cliccato,
  l'aggiunta e' consentita solo se non e' presente un elemento
  span con quest'attributo impostato
 */

let stars = document.querySelectorAll('.star');
let selectedStar = null;
let rating = 6;

stars.forEach(star => {
  star.addEventListener('click', function() {
    if (selectedStar) {
      selectedStar.removeAttribute('selected');
      rating = 6;
    }
    this.setAttribute('selected', 'true');
    selectedStar = this;
    
    for (let i = 0; i < stars.length; i++) {
      rating--;
      if (stars[i] === selectedStar) {
        break;
      }
    }
    console.log(rating);
  });
});

document.getElementById('submit-rating').addEventListener('click', function() {
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "./../admin/save_rating.php", true);
  xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  
  var data = JSON.stringify({rating: rating});
  xhttp.send(data);

  xhttp.onreadystatechange = function() {
    if (xhttp.readyState === 4) {
      if (xhttp.status === 200) {
        var response = JSON.parse(xhttp.responseText);
        if (response.success) {
          window.location.href = 'activity_created.php';
        } else {
          alert("Si è verificato un errore!");
        }
      } else {
        alert("Si è verificato un errore. Stato: " + xhttp.status);
      }
    }
  };
});