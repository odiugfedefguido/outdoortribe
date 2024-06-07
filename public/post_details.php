<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Verifica se l'utente è già autenticato e recupera i suoi dati dall'ID dell'utente salvato nella sessione
$user_data = checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post Details</title>
  <!-- Inclusione dei fogli di stile -->
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="stylesheet" href="./../templates/post/post.css">
  <link rel="stylesheet" href="./../templates/popup-likes/popup-likes.css">
  <link rel="stylesheet" href="./styles/post_details.css">
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
  <?php include("./../templates/header/header.html"); ?>

  <main>
    <?php
    // ID utente corrente 
    $current_user_id = $_SESSION['user_id'];

    // Verifica se è stato passato l'ID del post tramite GET
    if (isset($_GET['id'])) {
      $post_id = $_GET['id'];

      // Query per recuperare le informazioni del post corrispondente all'ID
      $post_query = "SELECT * FROM post WHERE id = $post_id";
      $result = $conn->query($post_query);

      if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();

        // $profile_photo_url = getProfilePhotoUrl($conn, $post['user_id']);
        $like_icon_class = getLike($conn, $post_id, $current_user_id);
        $user_info = getUserInfo($conn, $post['user_id']);

        if ($user_info !== false) {
          $user = $user_info;

          $average_rating = getAverageRating($conn, $post['id']);
          list($full_stars, $half_star) = getStars($average_rating);

          // Assegna i dati del post alle variabili
          $profile_photo_url = null;
          $title = $post['title'];
          $location = $post['location'];
          $activity = $post['activity'];
          $duration = $post['duration'];
          $length = $post['length'];
          $altitude = $post['max_altitude'];
          $difficulty = $post['difficulty'];
          $rating = $average_rating;
          $likes = $post['likes'];
          $is_post_details = true;

          // Inclusione del template del post
          include("./../templates/post/post.php");
        } else {
          echo "Errore: Impossibile trovare l'utente con ID " . $user_id;
        }
      } else {
        echo "Post non trovato.";
      }
    ?>

      <!-- Sezione per i waypoints del post -->
      <div class="waypoints-container">
        <?php
        // Query per recuperare i waypoints associati al post
        $waypoints_query = "SELECT * FROM waypoints WHERE post_id = $post_id";
        $waypoints_result = $conn->query($waypoints_query);
        ?>
        <img src="./../assets/icons/waypoints.svg" alt="route-icon">
        <h2>Waypoints</h2>
        <?php
        if ($waypoints_result->num_rows > 0) {
          // Se ci sono waypoints, li visualizza
          while ($waypoint = $waypoints_result->fetch_assoc()) {
        ?>
            <!-- Mostra i singoli waypoint -->
            <div class="waypoints">
              <div class="waipoints-1">
                <div class="icon"><img src="./../assets/icons/location.svg" alt=""></div>
                <div class="number"><?php echo $waypoint['km']; ?></div>
              </div>
              <div class="waypoints-2">
                <h2><?php echo $waypoint['title']; ?></h2>
                <div class="description"><?php echo $waypoint['description']; ?></div>
              </div>
            </div>
        <?php
          }
        } else {
          // Messaggio se non ci sono waypoints per il post
          echo "Nessun waypoint trovato per questo post.";
        }
        ?>
      </div>

      <!-- Sezione per i dati tecnici del post -->
      <div class="technical-data">
        <?php
        // Query per recuperare i dati tecnici del post
        $data_query = "SELECT * FROM post WHERE id = $post_id";
        $data_result = $conn->query($data_query);
        ?>
        <h2>Technical Data</h2>
        <?php
        if ($data_result->num_rows > 0) {
          $data = $data_result->fetch_assoc();
        ?>
          <!-- Mostra i dati tecnici del post -->
          <div class="grid-data">
            <div class="level">
              <p class="paragraph-450">Level:</p>
              <p class="paragraph-400"><?php echo $data['difficulty']; ?></p>
            </div>
            <div class="length">
              <p class="paragraph-450">Length:</p>
              <p class="paragraph-400"><?php echo $data['length'] . " km"; ?></p>
            </div>
            <div class="ascent">
              <p class="paragraph-450">Total ascent:</p>
              <p class="paragraph-400"><?php echo $data['max_ascent'] . " m"; ?></p>
            </div>
            <div class="descent">
              <p class="paragraph-450">Total descent:</p>
              <p class="paragraph-400"><?php echo $data['min_descent'] . " m"; ?></p>
            </div>
            <div class="max-altitude">
              <p class="paragraph-450">Max altitude:</p>
              <p class="paragraph-400"><?php echo $data['max_altitude'] . " m"; ?></p>
            </div>
            <div class="min-altitude">
              <p class="paragraph-450">Min altitude:</p>
              <p class="paragraph-400"><?php echo $data['min_altitude'] . " m"; ?></p>
            </div>
          </div>
        <?php
        } else {
          // Messaggio se non ci sono dati tecnici disponibili per il post
          echo "<p>Nessun dato tecnico disponibile per questo post.</p>";
        }
        ?>
      </div>

      <!-- Sezione per le immagini associate al post -->
      <div class="images">
        <?php
        // Query per recuperare le immagini associate al post
        $images_query = "SELECT * FROM photo WHERE post_id = $post_id";
        $images_result = $conn->query($images_query);
        $images_shown = 4;
        ?>
        <h2>Images</h2>
        <div class="image-scroll-container">
          <div class="image-container">
            <?php
            if ($images_result->num_rows > 0) {
              $i = 0;
              while ($i < $images_shown && $image = $images_result->fetch_assoc()) {
            ?>
                <!-- Mostra le immagini associate al post -->
                <img class="clickable-image" src="./../uploads/photos/post/<?php echo $image['name']; ?>" alt="Post Image">
              <?php
                $i++;
              }
              if ($images_result->num_rows > $images_shown) {
              ?>
                <!-- Visualizza un link "View All" se ci sono più immagini disponibili -->
                <div class="view-all-container">
                  <h2 class="view-all"><a href="post_images.php?post_id=<?php echo $post_id; ?>">View All</a></h2>
                </div>
            <?php
              }
            } else {
              // Messaggio se non ci sono immagini associate al post
              echo "Nessuna foto ancora caricata per questa avventura.";
            }
            ?>
          </div>
        </div>
      </div>

      <!-- Popup per visualizzare le immagini ingrandite -->
      <div class="popup-image">
        <img id="popupImg" src="" alt="Enlarged image">
      </div>

      <!-- Sezione per condividere il post -->
      <div class="share">
        <h2>Have you done this activity?</h2>
        <p class="paragraph-400">Add it to your activities and share it with your friends!</p>
        <input class="full-btn" type="button" value="Add and Share" onclick="sharePost(<?php echo $post_id; ?>)">
      </div>

    <?php
    } else {
      // Messaggio se l'ID del post non è specificato
      echo "ID del post non specificato.";
    }
    ?>
  </main>

  <!-- Inclusione del popup-likes-->
  <?php include('./../templates/popup-likes/popup-likes.html'); ?>

  <!-- Inclusione del footer -->
  <?php include("./../templates/footer/footer.html"); ?>

  <!-- Script JavaScript -->
  <script src="./../templates/post/post.js"></script>
  <script src="javascript/popup-images.js"></script>
  <script src="javascript/shared_posto.js"></script>
</body>

</html>