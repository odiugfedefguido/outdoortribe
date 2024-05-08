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
  <title>Other Profile</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../public/styles/profilepage.css">
  <link rel="stylesheet" href="./../public/styles/otherprofile.css">
 <link rel="stylesheet" href="./../templates/post/post.css">
 <link rel="icon" type="image/svg+xml" href="./../assets/icons/favicon.svg">
 
 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main>
  <?php
    // ID utente corrente 
    $current_user_id = 5; //$_SESSION['user_id']; (da sostituire con $_SESSION['user_id'])

    // Verifica se è stato passato l'ID del post tramite GET
    if (isset($_GET['id'])) {
      $post_id = $_GET['id'];

      //query per ottenre il nome e il cognome dell'utende dell'id passato
        $query_user = "SELECT name, surname
                FROM user
                WHERE id = ?";
        $stmt_user = $conn->prepare($query_user);
        $stmt_user->bind_param("i", $post_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();
        //echo '<h1>'.$user['name'].' '.$user['surname'].'</h1>';
        //query per ottenere il nuemro dei follower
        $query_follower = "SELECT COUNT(*)
                FROM follow
                WHERE followed_id = ?";
        $stmt_follower = $conn->prepare($query_follower);
        $stmt_follower->bind_param("i", $post_id);
        $stmt_follower->execute();
        $result_follower = $stmt_follower->get_result();
        $follower = $result_follower->fetch_assoc();
        //echo '<p>Followers: '.$follower['COUNT(*)'].'</p>';
        //query per ottenere il nuemro dei following
        $query_following = "SELECT COUNT(*)
                FROM follow
                WHERE follower_id = ?";
        $stmt_following = $conn->prepare($query_following);
        $stmt_following->bind_param("i", $post_id);
        $stmt_following->execute();
        $result_following = $stmt_following->get_result();
        $following = $result_following->fetch_assoc();
        $query_image = "SELECT name
                FROM photo
                WHERE user_id = ? AND post_id IS NULL";
        $stmt_image = $conn->prepare($query_image);
        $stmt_image->bind_param("i", $post_id);
        $stmt_image->execute();
        $result_image = $stmt_image->get_result();
        $photo_profile_row = $result_image->fetch_assoc();
        $profile_photo_url = "./../uploads/photos/profile/" . $photo_profile_row['name'];
        
        



      

       //query per ottenere i post dell'utente
       //inclusiione di post.php cosi da avere i dati del post

    
      // Messaggio se l'ID del post non è specificato
      //echo "ID del post non specificato.";
      $conn->close();
    }
    ?>
    <div class="profile-container">
    <!-- Foto profilo -->
    <div class="circular-square">
        <?php if (!empty($profile_photo_url)) { ?>
            <img class="circular-square-img" src="<?php echo $profile_photo_url; ?>" alt="profile-photo">
        <?php } else { ?>
            <div class="user-picture"></div>
        <?php } ?>
    </div>

    <!-- Nome utente -->
    <p class="profile-name"><?php echo $user['name'].' '.$user['surname']; ?></p>

    <!-- Bottone di Follow e Following -->
    <a href="./../public/follow.php?followed_id=<?php echo $post_id; ?>" class="check-btn">Follow</a>
</form>

</div>

</form>


        <form action="./../server/unfollow.php" method="post" class="button-column">
            <input type="hidden" name="followed_id" value="<?php echo $post_id; ?>">
            <button class="check-btn" type="submit">Following</button>
        </form>
    </div>
</div>




      </div>
  </main>

  <!-- Inclusione del footer -->
  <?php include("./../templates/footer/footer.html"); ?>

  <!-- Script JavaScript -->
  <script src="./../templates/post/post.js"></script>
  <script src="javascript/popup-images.js"></script>
</body>
