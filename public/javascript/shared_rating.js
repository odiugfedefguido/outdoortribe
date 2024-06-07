// Aggiunge un attributo "selected" all'elemento span cliccato,
// l'aggiunta è consentita solo se non è presente un elemento
// span con quest'attributo impostato

let stars = document.querySelectorAll(".star");
let rating = 6;
let selectedStar = null;
let selectedDifficulty = null;

stars.forEach((star) => {
  star.addEventListener("click", function () {
    if (selectedStar) {
      selectedStar.removeAttribute("selected");
      rating = 6;
    }
    this.setAttribute("selected", "true");
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


document.getElementById("submit-rating").addEventListener("click", function () {
  if (rating === 6) {
    alert("Please select a rating!");
    return;
  } else {
    // Ottieni il valore di post_id dalla query string
    const urlParams = new URLSearchParams(window.location.search);
    const post_id = parseInt(urlParams.get('post_id'));

    // Crea un oggetto contenente i dati da inviare al server
    const data = {
      rating: rating,
      post_id: post_id // Includi post_id nei dati da inviare
    };

    // Crea una richiesta XMLHttpRequest
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "./../admin/update_rating.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    // Invia i dati al server convertendoli in formato JSON
    xhttp.send(JSON.stringify(data));

    xhttp.onreadystatechange = function () {
      if (xhttp.readyState === 4) {
        if (xhttp.status === 200) {
          try {
            // DEBUG
            console.log("Risposta del server:", xhttp.responseText);
            var response = JSON.parse(xhttp.responseText);
            if (response.success) {
              window.location.href = "shared.php";
            } else {
              alert("Si è verificato un errore! shared rating");
            }
          } catch (e) {
            // DEBUG
            console.error("Errore durante il parsing della risposta JSON:", e);
            console.error("Risposta del server:", xhttp.responseText);
            alert("Si è verificato un errore di comunicazione con il server.");
          }
        } else {
          alert("Si è verificato un errore. Stato: " + xhttp.status);
        }
      }
    };
  }
});
