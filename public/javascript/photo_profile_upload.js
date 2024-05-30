document.getElementById("upload-button").addEventListener("click", function() {
  document.getElementById("file-input").click();
});

document.getElementById("file-input").addEventListener("change", preview);

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

      // Call the function to upload the photo and update the database
      uploadProfilePhoto(files[0]);
  }
}

function uploadProfilePhoto(file) {
  let formData = new FormData();
  formData.append("profile_photo", file);
  formData.append("user_id", 1); // Replace with dynamic user ID

  fetch('./../server/upload_profile_photo.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          // Update the profile photo on the page
          document.querySelector('.circular-square-img').src = data.new_photo_url;
      } else {
          alert('Failed to upload photo.');
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}
