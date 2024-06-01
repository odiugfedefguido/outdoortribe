<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Verifica se l'utente è già autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
//$user_data = checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Images</title>
  <!-- Inclusione dei fogli di stile -->
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./styles/post_details.css">
  <link rel="stylesheet" href="styles/post_images.css">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <!-- Collegamento al font Roboto -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <!-- Inclusione dell'header -->
  <?php include("./../templates/header/header.html"); ?>
  <main>
    <?php
    // Verifica se è stato passato l'ID del post tramite GET
    if (isset($_GET['post_id'])) {
      $post_id = $_GET['post_id'];

      // Query per selezionare le immagini associate al post specificato
      $images_query = "SELECT * FROM photo WHERE post_id = $post_id";
      $images_result = $conn->query($images_query);
    ?>

      <!-- Visualizza le immagini associate al post -->
      <div class="gallery">
        <?php
        // Se sono presenti immagini associate al post, le mostra
        if ($images_result->num_rows > 0) {
          while ($image = $images_result->fetch_assoc()) {
        ?>
            <!-- Immagine cliccabile per ingrandire -->
            <img class="clickable-image" src="./../uploads/photos/post/<?php echo $image['name']; ?>" alt="Post Image">
        <?php
          }
        }
        ?>
      </div>

      <!-- Popup per visualizzare le immagini ingrandite -->
      <div class="popup-image">
        <img id="popupImg" src="" alt="Enlarged image">
      </div>

    <?php
    } else {
      // Messaggio di errore se l'ID del post non è specificato
      echo "Errore: post_id non specificato.";
    }
    ?>
  </main>
  <!-- Inclusione del footer -->
  <?php include("./../templates/footer/footer.html"); ?>
  <!-- Script JavaScript -->
  <script src="javascript/popup-images.js"></script>
</body>

</html>