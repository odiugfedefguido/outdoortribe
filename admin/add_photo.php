<?php
session_start();
include ("../server/connection.php");
include ("functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
  $post_id = $_SESSION['post_id'];
  $user_id = $_SESSION['user_id'];

  $images = $_FILES['images'];
  $uploadPath = './../uploads/photos/post/';
  $allowedExtensions = ['jpg', 'jpeg', 'png'];

  $uploadErrors = []; // Array per memorizzare gli errori di caricamento

  foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $imageName = basename($_FILES['images']['name'][$key]);
    $imageType = pathinfo($imageName, PATHINFO_EXTENSION);
    $imageTmp = $_FILES['images']['tmp_name'][$key];

    if (in_array($imageType, $allowedExtensions)) {
      $newImageName = str_replace(' ', '_', uniqid('img', true) . '.' . strtolower($imageType));
      $imageUploadPath = $uploadPath . $newImageName;
      
      if (move_uploaded_file($imageTmp, $imageUploadPath)) {
        $insertQuery = "INSERT INTO photo (post_id, user_id, name) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        
        if ($insertStmt) {
          $insertStmt->bind_param('iis', $post_id, $user_id, $newImageName);
          
          if ($insertStmt->execute()) {
            // L'immagine è stata caricata e inserita correttamente nel database
          } else {
            $uploadErrors[] = "Il caricamento dell'immagine non e' andato a buon fine!";
          }
        } else {
          $uploadErrors[] = "Il caricamento dell'immagine non e' andato a buon fine!";
        }
      } else {
        $uploadErrors[] = "Il caricamento dell'immagine non e' andato a buon fine!";
      }
    } else {
      $uploadErrors[] = "Tipo di file non consentito: $imageType";
    }
  }
  $conn->close();

  // Verifica se ci sono errori di caricamento e mostra alert
  if (!empty($uploadErrors)) {
    echo '<script>';
    foreach ($uploadErrors as $error) {
      echo 'alert("' . $error . '");';
    }
    echo '</script>';
  } else {
    // Reindirizza alla pagina di rating se non ci sono errori
    header("Location: ./../public/rating.php");
    exit(); // Assicura che lo script termini dopo il reindirizzamento
  }
}
