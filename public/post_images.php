<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

//$user_data = checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Images</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./styles/post_details.css">
  <link rel="stylesheet" href="styles/post_images.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>
  <main>
    <?php
    if (isset($_GET['post_id'])) {
      $post_id = $_GET['post_id'];

      $images_query = "SELECT * FROM photo WHERE post_id = $post_id";
      $images_result = $conn->query($images_query);
    ?>

      <div class="gallery">
        <?php
        if ($images_result->num_rows > 0) {
          while ($image = $images_result->fetch_assoc()) {
        ?>
            <img class="clickable-image" src="./../uploads/photos/post/<?php echo $image['name']; ?>" alt="Post Image">
        <?php
          }
        }
        ?>
      </div>
      <!-- Popup per visualizzare immagini ingrandite -->
      <div class="popup-image">
        <img id="popupImg" src="" alt="Enlarged image">
      </div>

    <?php
    } else {
      echo "Errore: post_id non specificato.";
    }
    ?>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script src="javascript/popup-images.js"></script>
</body>

</html>