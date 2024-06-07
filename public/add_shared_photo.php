<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Assicurati che l'utente sia autenticato
checkLogin($conn);

// Ottieni l'ID del post dall'URL
if (isset($_GET['post_id'])) {
  $post_id = $_GET['post_id'];
} else {
  // Se l'ID del post non è specificato, reindirizza o mostra un messaggio di errore
  echo "ID del post non specificato.";
  exit();
}

// Visualizza eventuali messaggi di avviso
if (isset($_GET['alert_message'])) {
  echo '<script>alert("' . $_GET['alert_message'] . '");</script>';
}
?>


<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="/outdoortribe/templates/footer/footer.css">
  <link rel="stylesheet" href="/outdoortribe/templates/header/header.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="stylesheet" href="styles/photo_upload.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Images Upload</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <div class="upper-container">
      <!-- Contenuto del titolo e pulsante indietro -->
    </div> 
    <form class="upload-container" id="upload-form" action="./../admin/add_photo_shared.php" method="post" enctype="multipart/form-data">
      <!-- Input file per il caricamento delle immagini -->
      <input type="file" id="file-input" onchange="preview()" name="images[]" multiple>
      <label for="file-input">Select Photos</label>
      <!-- Paragrafo per visualizzare il numero di file selezionati -->
      <p id="num-files">No Files Chosen</p>
      <div id="images"></div>
      <!-- Input nascosto per passare l'ID del post -->
      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    </form>
    <div class="buttons-container">
      <!-- Pulsante di invio del modulo -->
      <button class="full-btn" id="full-btn" type="submit">Next</button>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <!-- Inclusione del file JavaScript per la gestione del caricamento delle immagini -->
  <script src="javascript/photo_upload.js"></script>
  <!-- Script per il debug -->
  <script>
    // DEBUG Stampa post_id e user_id nella console
    var postId = '<?php echo $post_id; ?>';
    console.log('Post ID:', postId);
    var userId = '<?php echo $user_id; ?>';
    console.log('User ID:', userId);
  </script>
</body>
</html>




