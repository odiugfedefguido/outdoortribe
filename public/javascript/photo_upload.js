let fileInput = document.getElementById("file-input");
let imageContainer = document.getElementById("images");
let numOfFiles = document.getElementById("num-files");

document.addEventListener("DOMContentLoaded", function() {
  const checkBtn = document.getElementById("full-btn");
  const checkForm = document.getElementById("upload-form");

  checkBtn.addEventListener("click", function(event) {
    event.preventDefault();
    if (checkForm.checkValidity()) {
      checkForm.submit();
    } else {
      checkForm.reportValidity();
    }
  });
});

function preview() {
  imageContainer.innerHTML = "";
  numOfFiles.textContent = `${fileInput.files.length} Files Selected`;

  for(i of fileInput.files) {
    let reader = new FileReader();
    let figure = document.createElement("figure");
    let figCap = document.createElement("figcaption");
    figCap.innerText = i.name;
    figure.appendChild(figCap);
    reader.onload=()=>{
      let image = document.createElement("img");
      image.className = "upload-image";
      image.src = reader.result;
      figure.insertBefore(image, figCap);
    }
    imageContainer.appendChild(figure);
    reader.readAsDataURL(i);
  }
}