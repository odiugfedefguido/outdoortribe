document.getElementById("upload-button").addEventListener("click", function() {
    document.getElementById("file-input").click();
});

document.getElementById("file-input").addEventListener("change", function() {
    document.getElementById("submit-button").click();
});

function preview() {
    let fileInput = document.getElementById("file-input");
    let imageContainer = document.getElementById("images");

    imageContainer.innerHTML = "";
    let files = fileInput.files;

    if (files.length > 0) {
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
    }
}