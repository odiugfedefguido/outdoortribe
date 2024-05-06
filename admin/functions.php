<?php

// Funzione per controllare se l'utente è autenticato
function checkLogin($conn)
{
  // Controlla se è stata avviata una sessione e se è presente l'ID dell'utente
  if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    // Query per selezionare l'utente dal database
    $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    // Esegue la query sul database
    $result = $conn->query($sql);

    // Verifica se esiste un risultato per la query
    if ($result->num_rows > 0) {
      // Recupera i dati dell'utente
      $user_data = $result->fetch_assoc();
      // Ritorna i dati dell'utente
      return $user_data;
    }
  } else {
    // Se l'utente non è autenticato, reindirizza alla pagina di login
    header("Location: login.php");
    // Interrompe l'esecuzione dello script
    die;
  }
}

// Funzione per ottenere l'URL della foto del profilo dell'utente
function getProfilePhotoUrl($conn, $user_id)
{
  // Query per selezionare la foto del profilo dell'utente
  $query_photo_profile = "SELECT name FROM photo WHERE user_id = $user_id AND post_id IS NULL";
  // Esegue la query sul database
  $result_photo_profile = $conn->query($query_photo_profile);

  // Verifica se esiste una foto del profilo associata all'utente
  if ($result_photo_profile->num_rows > 0) {
    // Recupera il nome della foto del profilo
    $photo_profile_row = $result_photo_profile->fetch_assoc();
    // Costruisce l'URL della foto del profilo
    $profile_photo_url = "./../uploads/photos/profile/" . $photo_profile_row['name'];
  } else {
    // Se non c'è una foto del profilo associata all'utente, utilizza un'immagine predefinita
    $profile_photo_url = "./../assets/icons/profile.svg";
  }
  // Ritorna l'URL della foto del profilo
  return $profile_photo_url;
}

// Funzione per ottenere la media dei rating per un determinato post
function getAverageRating($conn, $post_id)
{
  // Query per calcolare la media dei rating per il post
  $query_average_rating = "SELECT AVG(rating) AS average_rating FROM post_ratings WHERE post_id = ?";
  // Prepara la query per l'esecuzione
  $stmt_avg_rating = $conn->prepare($query_average_rating);
  // Associa i parametri alla query
  $stmt_avg_rating->bind_param("i", $post_id);
  // Esegue la query
  $stmt_avg_rating->execute();
  // Ottiene il risultato della query
  $result_avg_rating = $stmt_avg_rating->get_result();

  // Estrae la media dei rating dal risultato della query
  $average_rating_row = $result_avg_rating->fetch_assoc();
  $average_rating = $average_rating_row['average_rating'];

  // Gestisce il caso in cui non ci sono valutazioni per il post
  if ($average_rating === null) {
    $average_rating = 0;
  }
  // Ritorna la media dei rating
  return $average_rating;
}

// Funzione per ottenere il numero di stelle piene e mezze in base al rating
function getStars($rating)
{
  // Calcola il numero di stelle piene (parte intera del rating)
  $full_stars = floor($rating);
  // Calcola il numero di mezze stelle (parte decimale del rating)
  $half_star = ceil($rating - $full_stars);
  // Ritorna il numero di stelle piene e mezze
  return array($full_stars, $half_star);
}

// Funzione per verificare se l'utente ha messo like a un post
function getLike($conn, $post_id, $current_user_id)
{
  // Query per verificare se l'utente ha messo like a questo post
  $checkQuery = "SELECT COUNT(*) FROM likes WHERE post_id = {$post_id} AND user_id = $current_user_id";
  // Esegue la query sul database
  $checkResult = mysqli_query($conn, $checkQuery);
  // Estrae il risultato della query
  $row_likes = mysqli_fetch_array($checkResult);

  // Se l'utente ha messo like a questo post, imposta la classe corrispondente
  if ($row_likes[0] > 0) {
    $like_icon_class = 'like-icon liked';
  } else {
    $like_icon_class = 'like-icon';
  }
  // Ritorna la classe del like
  return $like_icon_class;
}

// Funzione per ottenere le informazioni dell'utente
function getUserInfo($conn, $user_id)
{
  // Query per selezionare il nome e il cognome dell'utente dal database
  $user_query = "SELECT name, surname FROM user WHERE id = $user_id";
  // Esegue la query sul database
  $user_result = $conn->query($user_query);

  // Verifica se esiste un risultato per la query
  if ($user_result && $user_result->num_rows > 0) {
    // Recupera i dati dell'utente
    return $user_result->fetch_assoc();
  } else {
    return false; // Ritorna false se l'utente non è stato trovato
  }
}