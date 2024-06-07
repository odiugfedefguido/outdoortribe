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

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".option-container").forEach((container) => {
    container.addEventListener("click", function () {
      const input = this.querySelector("input");
      const label = this.querySelector("label").innerText.toLowerCase();
      input.checked = true;
      const descriptionElement = document.getElementById(
        "difficulty-description"
      );
      descriptionElement.textContent = `You have chosen ${label} difficulty!`;
      descriptionElement.style.display = "block";
      selectedDifficulty = label;
    });
  });
});

document.getElementById("submit-rating").addEventListener("click", function () {
  let post_id = document.getElementById("post-id").value; // Assuming post ID is stored in an input field with id "post-id"
  if (rating === 6) {
    alert("Please select a rating!");
    return;
  } else if (!selectedDifficulty) {
    alert("Please select a difficulty!");
    return;
  } else {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "./../admin/update_rating.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    var data = JSON.stringify({
      rating: rating,
      difficulty: selectedDifficulty,
      post_id: post_id,
    });
    xhttp.send(data);

    xhttp.onreadystatechange = function () {
      if (xhttp.readyState === 4) {
        if (xhttp.status === 200) {
          try {
            // DEBUG
            console.log("Risposta del server:", xhttp.responseText);
            var response = JSON.parse(xhttp.responseText);
            if (response.success) {
              window.location.href = "rating.php";
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
