<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Verifica se l'utente è già autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searching</title>
  <!-- Inclusione dei fogli di stile -->
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../templates/post/post.css">
  <link rel="stylesheet" href="./../templates/popup-likes/popup-likes.css">
  <link rel="stylesheet" href="./styles/searching.css">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <!-- Collegamento al font Roboto -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <!-- Inclusione di jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <!-- Inclusione dell'header -->
  <?php include('./../templates/header/header.html'); ?>
  <main>
    <?php
    // ID utente corrente 
    $current_user_id = $_SESSION['user_id'];

    // Verifica se sono stati passati parametri di ricerca
    if (isset($_GET['location']) && isset($_GET['activity'])) {
      // Recupera i valori della località e dell'attività
      $location = '%' . $_GET['location'] . '%';
      $activity = $_GET['activity'];

      // Query per ottenere i post 
      $query = "SELECT *,
                (SELECT COUNT(*) FROM shared_post WHERE post_id = post.id) AS shares 
                FROM post
                WHERE location LIKE ? 
                AND activity = ?";

      // Prepara la query
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ss", $location, $activity);
      $stmt->execute();
      $post_result = $stmt->get_result();

      // Se ci sono risultati, mostra i post in ordine cronologico
      if ($post_result->num_rows > 0) {
        while ($post = $post_result->fetch_assoc()) {

          // Ottiene l'URL della foto profilo dell'utente che ha creato il post
          $profile_photo_url = getProfilePhotoUrl($conn, $post['user_id']);

          // Ottiene la classe dell'icona like in base al like dell'utente corrente per il post
          $like_icon_class = getLike($conn, $post['id'], $current_user_id);

          // Ottiene le informazioni dell'utente che ha creato il post
          $user_info = getUserInfo($conn, $post['user_id']);

          // Se sono disponibili informazioni sull'utente, mostra il post
          if ($user_info !== false) {
            $user = $user_info;

            // Ottiene la valutazione media del post
            $average_rating = getAverageRating($conn, $post['id']);
            list($full_stars, $half_star) = getStars($average_rating);

            // Variabili del post
            $user_id = ($post['user_id'] == $current_user_id) ? null : $post['user_id'];
            $shares = $post['shares'];
            $post_id = $post['id'];
            $username = $user['name'] . ' ' . $user['surname'];
            $title = $post['title'];
            $location = $post['location'];
            $activity = $post['activity'];
            $duration = $post['duration'];
            $length = $post['length'];
            $altitude = $post['max_altitude'];
            $difficulty = $post['difficulty'];
            $rating = $average_rating;
            $likes = $post['likes'];
            $is_post_details = false;

            // Inclusione del template del post
            include('./../templates/post/post.php');
          } else {
            // Mostra un messaggio di errore se non è possibile trovare l'utente con l'ID specificato
            echo "Errore: Impossibile trovare l'utente con ID " . $user_id;
          }
        }
      } else {
        // Mostra un messaggio se non ci sono post disponibili per la ricerca effettuata
        echo "Nessun post disponibile";
      }
    }
    // Chiude la connessione al database
    $conn->close();
    ?>
    <!-- Spazio vuoto per migliorare l'aspetto della pagina -->
    <div class="empty-space"></div>
  </main>

  <!-- Inclusione del popup-likes-->
  <?php include('./../templates/popup-likes/popup-likes.html'); ?>

  <!-- Inclusione del footer -->
  <?php include('./../templates/footer/footer.html'); ?>

  <!-- Script JavaScript -->
  <script src="./../templates/post/post.js"></script>
</body>

</html>