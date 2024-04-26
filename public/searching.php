<?php
session_start();
include("./../server/connection.php");
include("./../server/functions.php");

//$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searching</title>
  <link rel="stylesheet" href="./../templates/styles/header.css">
  <link rel="stylesheet" href="./../templates/styles/footer.css">
  <link rel="stylesheet" href="./../templates/styles/post.css">
  <link rel="stylesheet" href="./styles/searching.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include('./../templates/header.html'); ?>
<main>
  <?php
    if(isset($_GET['location']) && isset($_GET['activity'])) {
      // Recupera i valori della località e dell'attività
      $location = '%' . $_GET['location'] . '%';
      $activity = $_GET['activity'];

      // Query per ottenere i post 
      $query = "SELECT *
                FROM post
                WHERE location LIKE ? 
                AND activity = ?";

      // Prepara la query
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ss", $location, $activity);
      $stmt->execute();
      $post_result = $stmt->get_result();

      // Se ci sono, mostra i post in ordine cronologico
      if ($post_result->num_rows > 0) {
        while ($row = $post_result->fetch_assoc()) {
          $query_photo_profile = "SELECT name FROM photo WHERE user_id = $row[user_id] AND post_id IS NULL";
          $result_photo_profile = $conn->query($query_photo_profile);

          // Verifica se c'è una foto del profilo associata all'utente che ha creato il post
          if ($result_photo_profile->num_rows > 0) {
            $photo_profile_row = $result_photo_profile->fetch_assoc();
            $profile_photo_url = "./../assets/photos/profile/" . $photo_profile_row['name'];
          } else {
            // Se non c'è una foto del profilo associata all'utente, utilizza un'immagine predefinita
            $profile_photo_url = "./../assets/icons/profile.svg";
          }

          // Query per ottenere il nome e il cognome dell'utente
          $user_query = "SELECT name, surname FROM user WHERE id = " . $row['user_id'];
          $user_result = $conn->query($user_query);

          if ($user_result && $user_result->num_rows > 0) {
            $row_user = $user_result->fetch_assoc();

            // Passa le variabili al template
            $post_id = $row['id'];
            $username = $row_user['name'] . ' ' . $row_user['surname'];
            $title = $row['title'];
            $location = $row['location'];
            $activity = $row['activity'];
            $duration = $row['duration'];
            $length = $row['length'];
            $altitude = $row['altitude'];
            $difficulty = $row['difficulty'];
            $rating = $row['rating'];
            $likes = $row['likes'];
            $is_post_details = false;

            include ('./../templates/post.php');
          } 
        }
      }
    } else {
      echo "Nessun post disponibile";
    }
  $conn->close();
  ?>
  <div class="empty-space"></div>
</main>
<?php include('./../templates/footer.html'); ?>
</body>
</html>