<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Verifica se l'utente è già autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
$current_user_id = 2;//$_SESSION['user_id'];

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
  <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
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
    // Query per selezionare le immagini dei post dell'utente corrente (escludendo la foto del profilo)
    $images_query = "SELECT * FROM photo WHERE user_id = ? AND post_id IS NOT NULL";
    $stmt = $conn->prepare($images_query);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $images_result = $stmt->get_result();
    
    ?>

      <!-- Visualizza le immagini associate ai post dell'utente -->
      <div class="gallery">
        <?php
        // Se sono presenti immagini associate ai post dell'utente, le mostra
        if ($images_result->num_rows > 0) {
          while ($image = $images_result->fetch_assoc()) {
        ?>
            <!-- Immagine cliccabile per ingrandire -->
            <img class="clickable-image" src="./../uploads/photos/post/<?php echo $image['name']; ?>" alt="User Image">
        <?php
          }
        } else {
            echo "<p>Nessuna immagine trovata per i post di questo utente.</p>";
        }
        ?>
      </div>

      <!-- Popup per visualizzare le immagini ingrandite -->
      <div class="popup-image">
        <img id="popupImg" src="" alt="Enlarged image">
      </div>

  </main>
  <!-- Inclusione del footer -->
  <?php include("./../templates/footer/footer.html"); ?>
  <!-- Script JavaScript -->
  <script src="javascript/popup-images.js"></script>
</body>

</html>
