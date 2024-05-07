<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

//$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
 
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

        <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn"></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="#home">change profile photo</a>
                        <a href="#about">remove profile photo</a>
                    </div>
                </div>    
        
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
</script>

</body>

</html>