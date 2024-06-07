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
  <title>HomePage</title>
  <!-- Inclusione dei fogli di stile -->
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../templates/post/post.css">
  <link rel="stylesheet" href="./../templates/popup-likes/popup-likes.css">
  <link rel="stylesheet" href="./styles/homepage.css">
  <!-- Icona del favicon -->
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <!-- Collegamento al font Roboto -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <!-- Inclusione della libreria jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <!-- Inclusione dell'header -->
  <?php include('./../templates/header/header.html'); ?>
  <main>
    <?php
    // ID utente corrente 
    $current_user_id = $_SESSION['user_id'];

    // Query per ottenere i post delle persone che l'utente segue
    $query_search = "SELECT post.*, user.name, user.surname, shared_post.shared_at, 
                      (SELECT COUNT(*) FROM likes WHERE post_id = post.id AND user_id = ?) AS user_liked 
                    FROM shared_post  
                    INNER JOIN post ON shared_post.post_id = post.id 
                    INNER JOIN user ON shared_post.user_id = user.id 
                    INNER JOIN follow ON shared_post.user_id = follow.followed_id 
                    WHERE follow.follower_id = ? 
                    ORDER BY shared_post.shared_at DESC";

    // Esegue la query
    $stmt = $conn->prepare($query_search);
    $stmt->bind_param("ii", $current_user_id, $current_user_id);
    $stmt->execute();
    $result_search = $stmt->get_result();

    // Se ci sono, mostra i post in ordine cronologico
    if ($result_search->num_rows > 0) {
      while ($post = $result_search->fetch_assoc()) {
        // Recupera l'URL dell'immagine del profilo, il rating medio del post e i nomi degli utenti che hanno messo like
        $profile_photo_url = getProfilePhotoUrl($conn, $post['user_id']);
        $average_rating = getAverageRating($conn, $post['id']);
        list($full_stars, $half_star) = getStars($average_rating);

        // Assegna i dati del post alle variabili
        $user_id = ($post['user_id'] == $current_user_id) ? null : $post['user_id'];
        $post_id = $post['id']; 
        $username = $post['name'] . ' ' . $post['surname'];
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
        $like_icon_class = $post['user_liked'] ? 'like-icon liked' : 'like-icon';

        // Inclusione del template del post
        include('./../templates/post/post.php');
      }
    } else {
      // Messaggio se non ci sono post disponibili
      echo "Nessun post disponibile";
    }
    $conn->close();
    ?>
    <!-- Spazio vuoto per la formattazione -->
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