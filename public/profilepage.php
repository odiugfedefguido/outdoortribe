<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

//$user_data = check_login($conn);

// Verifica se è stato inviato il form per rimuovere la foto del profilo
if(isset($_POST['remove_photo']) && $_POST['remove_photo'] == "remove") {
  // Query per eliminare la foto del profilo dal database
  $query_delete = "DELETE FROM photo WHERE user_id = ? AND post_id IS NULL";
  $stmt = $conn->prepare($query_delete);
  $stmt->bind_param("i", $current_user_id);
  $stmt->execute();
  $stmt->close();


  // Verifica se è stato inviato il form per aggiornare la foto del profilo
if(isset($_FILES["profilePic"]["tmp_name"])) {
  if ($_FILES["profilePic"]["error"] === UPLOAD_ERR_OK) {
      $newImage = file_get_contents($_FILES["profilePic"]["tmp_name"]);
      // Esegui la logica per aggiornare l'immagine del profilo nel database
      $modifiche_eseguite = updateImgProfile($newImage, $current_user_id); // Assumendo che $current_user_id sia l'ID dell'utente attuale
      if($modifiche_eseguite) {
          // Aggiornamento riuscito
          // Redirect o mostra un messaggio di successo
      } else {
          // Aggiornamento non riuscito
          // Gestisci l'errore
      }
  } else {
      $error_message .= "Errore durante il caricamento dell'immagine del profilo. ";
  }
}

// Funzione per aggiornare l'immagine del profilo nel database
function updateImgProfile($newImg, $user){
  global $conn; // Assumi che la connessione al database sia globale
  $sql = "UPDATE user SET imgProfile = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $newImg, $user);
  $result = $stmt->execute();
  $stmt->close();
  
  return $result;    
}

    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">

  <link rel="stylesheet" href="./styles/profilepage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>
  

  <main>
    <?php

        $current_user_id = 1; //$_SESSION['user_id'];

        

        //query per ottenere il nome della persona
        $query_search = "SELECT user.name, user.surname 
            FROM user
            WHERE user.id = ?";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $name = $row['name'];
        $surname = $row['surname'];

        //query per ottenere il numero di follower
        $query_search = "SELECT COUNT(follower_id) as followers
              FROM follow
              WHERE follow.followed_id = ?";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $followers = $row['followers'];

        //query per ottenere il numero di persone seguite
        $query_search = "SELECT COUNT(followed_id) as followed
              FROM follow
              WHERE follow.follower_id = ?";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $followed = $row['followed'];

        //query per ottene la foto del profilo
        $query_search = "SELECT name
              FROM photo
              WHERE user_id = ? AND post_id IS NULL";
        $stmt = $conn->prepare($query_search);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result_search = $stmt->get_result();
        $row = $result_search->fetch_assoc();
        $profile_photo = $row['name'];

        $conn->close();

    ?>

      <div class="profile-container">
          <div class="circular-square">
              <!-- Condizione per verificare se c'è una foto del profilo -->
              <?php if (!empty($profile_photo)) { ?>
                  <img class="circular-square-img" src="./../uploads/photos/profile/<?php echo $profile_photo; ?>" alt="profile-photo">
              <?php } else { ?>
                  <!-- Se non c'è una foto del profilo, visualizza un'icona predefinita o un placeholder -->
                  <div class="user-picture"></div>
              <?php } ?>
          </div>
      </div>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="profilePic">
        <button type="submit" name="edit_photo">Edit Photo</button>
    </form>

    <form id="remove_photo_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display: none;">
        <input type="hidden" name="remove_photo" value="remove">
    </form>
    <button onclick="document.getElementById('remove_photo_form').submit()">Remove Photo</button>
    
        
        <p class="profile-name"><?php echo $name . " " . $surname; ?></p>
        <div class="buttons-container">
            <div class="button-column">
                <!-- fomr per il bottone followers -->
                <form action="./../public/followers.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                    <button class="check-btn" type="submit"><?php echo $followers; ?> FOLLOWERS</button>
                </form>
            </div>

            <div class="button-column">
               <!-- form per il bottone follow -->
               <form action="./../public/follow.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                    <button class="check-btn" type="submit"><?php echo $followed; ?> FOLLOWING</button>
               </form>
            </div>
        </div>

        <div class="word-font">Adventures</div>
        <div class="empty-buttons-container"> 
            <!-- form per il bottone done -->
            <form action="./../public/adeventuresdone.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Done</button>
            </form>

            <!-- form per il bottone liked -->
            <form action="./../public/adventuresliked.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Liked</button>
            </form>

            <!-- form per il bottone created -->
            <form action="./../public/adventurescreated.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Created</button>
            </form>
        </div>

        <div class="word-font">Media</div>
        <div class="empty-buttons-container"> 
            <!-- form per il bottone photos -->
            <form action="./../public/adventuresphoto.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                <button class="empty-check-btn" type="submit">Photos</button>
            </form>
        </div>

  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

<script>
    
    function removePhoto() {
        document.getElementById('remove_photo_form').submit();
    }
  </script>
</script>

</body>

</html>