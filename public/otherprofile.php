<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

checkLogin($conn);
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
  <link rel="stylesheet" href="./../templates/popup-likes/popup-likes.css">
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
    $current_user_id = $_SESSION['user_id'];

    // Verifica se è stato passato l'ID dell'utente visitato tramite GET
    if (isset($_GET['id'])) {
      $post_id = intval($_GET['id']); // Assicura che l'ID sia un intero

      //query per ottenere il nome e il cognome dell'utente dell'ID passato
      $query_user = "SELECT name, surname
                     FROM user
                     WHERE id = ?";
      $stmt_user = $conn->prepare($query_user);
      $stmt_user->bind_param("i", $post_id);
      $stmt_user->execute();
      $result_user = $stmt_user->get_result();
      $user = $result_user->fetch_assoc();

      // Verifica se l'utente corrente segue già l'utente del profilo
      $query_check_follow = "SELECT * FROM follow WHERE follower_id = ? AND followed_id = ?";
      $stmt_check_follow = $conn->prepare($query_check_follow);
      $stmt_check_follow->bind_param("ii", $current_user_id, $post_id);
      $stmt_check_follow->execute();
      $result_check_follow = $stmt_check_follow->get_result();
      $is_following = $result_check_follow->num_rows > 0;

      //query per ottenere il numero dei follower
      $query_follower = "SELECT COUNT(follower_id) as followers
                         FROM follow
                         WHERE follow.followed_id = ?";
      $stmt_follower = $conn->prepare($query_follower);
      $stmt_follower->bind_param("i", $post_id);
      $stmt_follower->execute();
      $result_follower = $stmt_follower->get_result();
      $follower_row = $result_follower->fetch_assoc();
      $follower = $follower_row['followers'];

      //query per ottenere il numero dei followed
      $query_followed = "SELECT COUNT(followed_id) as followed
                         FROM follow
                         WHERE follow.follower_id = ?";
      $stmt_followed = $conn->prepare($query_followed);
      $stmt_followed->bind_param("i", $post_id);
      $stmt_followed->execute();
      $result_followed = $stmt_followed->get_result();
      $followed_row = $result_followed->fetch_assoc();
      $following = $followed_row['followed'];

      //query per ottenere la foto profilo dell'utente
      $query_image = "SELECT name
                      FROM photo
                      WHERE user_id = ? AND post_id IS NULL";
      $stmt_image = $conn->prepare($query_image);
      $stmt_image->bind_param("i", $post_id);
      $stmt_image->execute();
      $result_image = $stmt_image->get_result();
      $photo_profile_row = $result_image->fetch_assoc();
      $profile_photo_url = !empty($photo_profile_row['name']) ? "./../uploads/photos/profile/" . $photo_profile_row['name'] : "./../assets/icons/profile.svg";
    }
    ?>

    <div class="profile-info">
      <!-- Foto profilo -->
      <div class="circular-square">
        <img style="background-color: black;" class="circular-square-img" src="<?php echo $profile_photo_url; ?>" alt="profile-photo">
      </div>

      <!-- Nome utente -->
      <p class="profile-name"><?php echo $user['name'] . ' ' . $user['surname']; ?></p>

      <!-- Bottone +Follow -->
      <form id="followForm" action="" method="post">
        <input type="hidden" name="followed_id" value="<?php echo $post_id; ?>">
        <button id="followButton" class="plusfollow-button" type="button"><?php echo $is_following ? 'UNFOLLOW' : 'FOLLOW'; ?></button>
      </form>
    </div>

    <div class="buttons-container">
      <div class="button-column">
        <!-- Form per il bottone followers -->
        <form action="./../public/followers.php" method="get">
          <input type="hidden" name="follower_id" value="<?php echo $post_id; ?>">
          <button class="check-btn" type="submit"><?php echo $follower; ?> FOLLOWERS</button>
        </form>
      </div>

      <div class="button-column">
        <!-- Form per il bottone followed -->
        <form action="./../public/follow.php" method="get">
          <input type="hidden" name="followed_id" value="<?php echo $post_id; ?>">
          <button class="check-btn" type="submit"><?php echo $following; ?> FOLLOWED</button>
        </form>
      </div>
    </div>

    <?php
    //query per ottenere i post dell'utente
    $query_post = "SELECT post.id, post.title, post.location, post.user_id, post.duration, post.length, post.max_altitude, post.difficulty, post.activity, post.likes,
    (SELECT COUNT(*) FROM shared_post WHERE post_id = post.id) AS shares,
    (SELECT COUNT(*) FROM likes WHERE post_id = post.id AND user_id = ?) AS user_liked
    FROM post
    JOIN user ON post.user_id = user.id
    WHERE post.user_id = ?
    ORDER BY post.created_at DESC";

    $stmt_post = $conn->prepare($query_post);
    $stmt_post->bind_param("ii", $current_user_id, $post_id);
    $stmt_post->execute();
    $result_post = $stmt_post->get_result();
    $posts = $result_post->fetch_all(MYSQLI_ASSOC);

    //se ci sono post, mostra i post in ordine cronologico
    if ($result_post->num_rows > 0) {
      foreach ($posts as $post) {
        //recupera l'immagine del profilo dell'utente, il rating medio del post e i nomi degli utenti che hanno messo like
        $profile_photo_url = getProfilePhotoUrl($conn, $post['user_id']);
        $average_rating = getAverageRating($conn, $post['id']);
        list($full_stars, $half_star) = getStars($average_rating);

        // Ottieni l'ID del post
        $post_id = $post['id'];
        $shares = $post['shares'];
        $user_id = $post['user_id'];
        $username = $user['name'] . ' ' . $user['surname'];
        $title = $post['title'];
        $location = $post['location'];
        $activity = $post['activity'];

        $duration = $post['duration'];
        $length = $post['length'];
        $altitude = $post['max_altitude'];
        $difficulty = $post['difficulty'];

        $likes = isset($post['likes']) ? $post['likes'] : 0; // Controlla se il campo 'likes' è impostato nell'array $row
        $user_liked = $post['user_liked']; // Ottieni il valore di 'user_liked' dall'array $row

        $is_post_details = false;
        $like_icon_class = $user_liked ? 'like-icon liked' : 'like-icon';

        //inclusione di post.php cosi da avere i dati del post
        include("./../templates/post/post.php");
      }
    } else {
      // Messaggio se l'ID del post non è specificato
      echo "Non sono ancora stati caricati dei post.";
    }
    $conn->close();
    ?>

  </main>

  <!-- Inclusione del popup-likes-->
  <?php include('./../templates/popup-likes/popup-likes.html'); ?>

  <!-- Inclusione del footer -->
  <?php include("./../templates/footer/footer.html"); ?>

  <!-- Script JavaScript -->
  <script src="./../templates/post/post.js"></script>
  <script src="javascript/popup-images.js"></script>
  <script src="./../public/javascript/otherprofile.js"></script>
</body>

</html>