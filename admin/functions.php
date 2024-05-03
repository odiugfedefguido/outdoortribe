<?php
function checkLogin($conn)
{
  if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $user_data = $result->fetch_assoc();
      return $user_data;
    }
  } else {
    header("Location: login.php");
    die;
  }
}

function getProfilePhotoUrl($conn, $user_id)
{
  $query_photo_profile = "SELECT name FROM photo WHERE user_id = $user_id AND post_id IS NULL";
  $result_photo_profile = $conn->query($query_photo_profile);

  // Verifica se c'è una foto del profilo associata all'utente che ha creato il post
  if ($result_photo_profile->num_rows > 0) {
    $photo_profile_row = $result_photo_profile->fetch_assoc();
    $profile_photo_url = "./../uploads/photos/profile/" . $photo_profile_row['name'];
  } else {
    // Se non c'è una foto del profilo associata all'utente, utilizza un'immagine predefinita
    $profile_photo_url = "./../assets/icons/profile.svg";
  }
  return $profile_photo_url;
}

function getAverageRating($conn, $post_id)
{
  $query_average_rating = "SELECT AVG(rating) AS average_rating FROM post_ratings WHERE post_id = ?";
  $stmt_avg_rating = $conn->prepare($query_average_rating);
  $stmt_avg_rating->bind_param("i", $post_id);
  $stmt_avg_rating->execute();
  $result_avg_rating = $stmt_avg_rating->get_result();

  // Estrae la media dei rating
  $average_rating_row = $result_avg_rating->fetch_assoc();
  $average_rating = $average_rating_row['average_rating'];

  // Gestione caso in cui non ci siano valutazioni per il post
  if ($average_rating === null) {
    $average_rating = 0;
  }
  return $average_rating;
}

function getStars($rating)
{
  $full_stars = floor($rating); // Numero di stelle piene (parte intera)
  $half_star = ceil($rating - $full_stars); // Controllo se c'è una mezza stella
  return array($full_stars, $half_star);
}

function getLike($conn, $post_id, $current_user_id)
{
  // Verifichi se l'utente ha messo like a questo post
  $checkQuery = "SELECT COUNT(*) FROM likes WHERE post_id = {$post_id} AND user_id = $current_user_id";
  $checkResult = mysqli_query($conn, $checkQuery);
  $row_likes = mysqli_fetch_array($checkResult);

  // Se l'utente ha messo like a questo post, imposta la classe corrispondente
  if ($row_likes[0] > 0) {
    $like_icon_class = 'like-icon liked';
  } else {
    $like_icon_class = 'like-icon';
  }
  return $like_icon_class;
}

function getUserInfo($conn, $user_id) {
  $user_query = "SELECT name, surname FROM user WHERE id = $user_id";
  $user_result = $conn->query($user_query);

  if ($user_result && $user_result->num_rows > 0) {
      return $user_result->fetch_assoc();
  } else {
      return false; // Ritorna false se l'utente non è stato trovato
  }
}

