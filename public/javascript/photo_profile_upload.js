let fileInput = document.getElementById("file-input");
let imageContainer = document.getElementById("images");
let numOfFiles = document.getElementById("num-files");

function preview() {
  imageContainer.innerHTML = "";
  let files = fileInput.files;

  if (files.length > 0) {
    numOfFiles.textContent = `1 File Selected`;

    let reader = new FileReader();
    let figure = document.createElement("figure");
    let figCap = document.createElement("figcaption");
    figCap.innerText = files[0].name;
    figure.appendChild(figCap);

    reader.onload = () => {
      let image = document.createElement("img");
      image.className = "upload-image";
      image.src = reader.result;
      figure.insertBefore(image, figCap);
    }

    imageContainer.appendChild(figure);
    reader.readAsDataURL(files[0]);
  } else {
    numOfFiles.textContent = `No File Selected`;
  }
}
