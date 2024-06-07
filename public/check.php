<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

if (isset($_SESSION['post_id'])) {
  $post_id = $_SESSION['post_id'];
  // Elimina la variabile di sessione per evitare che venga usata di nuovo accidentalmente
  /* unset($_SESSION['post_id']); */
} else {
  // Gestisci il caso in cui il post_id non è presente
  $post_id = 'N/A';
}

$getWaypointsQuery = "SELECT coordinates FROM waypoints WHERE post_id = ?";
$getWaypointsStmt = $conn->prepare($getWaypointsQuery);
$getWaypointsStmt->bind_param('i', $post_id);
$getWaypointsStmt->execute();
$waypointsResult = $getWaypointsStmt->get_result();

// Array per memorizzare le coordinate dei waypoints
$waypointCoordinates = array();

// Estrai le coordinate e memorizzale nell'array
while ($row = $waypointsResult->fetch_assoc()) {
  $waypointCoordinates[] = $row['coordinates'];
}

// Debug: stampa le coordinate dei waypoints nella console
echo "<script>console.log('Coordinate dei waypoints:', " . json_encode($waypointCoordinates) . ");</script>";

// Query per contare il numero di waypoints associati al post_id corrente
$countWaypointsQuery = "SELECT COUNT(*) AS waypoint_count FROM waypoints WHERE post_id = ?";
$countWaypointsStmt = $conn->prepare($countWaypointsQuery);
$countWaypointsStmt->bind_param('i', $post_id);
$countWaypointsStmt->execute();
$countResult = $countWaypointsStmt->get_result();
$row = $countResult->fetch_assoc();
$waypoint_count = $row['waypoint_count'];

// Gestione dell'errore nel caso in cui la query non vada a buon fine
if ($waypoint_count === false) {
  // Gestisci l'errore
  die("Errore nella query per contare i waypoints: " . $conn->error);
}

// Debug: stampa il numero di waypoints nella console
echo "<script>console.log('Numero di waypoints:', $waypoint_count);</script>";
?>

<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="./styles/check.css">  
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Check</title>
</head>
  <body>
 <?php include ('./../templates/header/header.html'); ?>
  <main class="outer-flex-container">
  <div class="upper-container">
    <div class="back-btn-container">
      <a href="./createactivity.php" class="back-button">
        <img class="back-icon" src="/outdoortribe/assets/icons/back-icon.svg" alt="back-icon">
      </a>
    </div>
    <div class="title-container">
      <h1>Waypoints</h1>
    </div>
  </div>
    <div class="paragraph-400">
      <p>Have you encountered anything along the way that you shouldn't miss?</p>
      <p>Select the waypoints along the the route and give them a description</p>
    </div>
    <div class="image-container">
      <img src="../assets/icons/map.svg" alt="map">
    </div>
    <form class="form-container" action="./../admin/set_waypoint_info.php" method="post">
      <?php
        // Utilizza un loop per generare gli input con le coordinate dei waypoints
        foreach ($waypointCoordinates as $index => $coordinates) {
          echo '<div class="inner-form-container">';
          echo '<div class="coords-container">';
          echo '<label class="label-hidden" for="coordinates">Coordinates</label>';
          echo '<input type="text" id="coordinates_' . $index . '" value="' . $coordinates . '" readonly>';
          echo '<input type="hidden" name="coordinates[' . $index . ']" value="' . $coordinates . '">';
          echo '</div>';
          echo '<div class="text-container">';
          echo '<label class="label-hidden" for="landmark">Landmark</label>';
          echo '<input type="text" id="landmark_' . $index . '" name="title[' . $index . ']" placeholder="Title">';
          echo '<label class="label-hidden" for="description">Description</label>';
          echo '<input type="text" id="description_' . $index . '" name="description[' . $index . ']" placeholder="Description (optional)">';
          echo '</div>';
          echo '</div>';
        }
      ?>
      <div class="buttons-container">
        <button class="full-btn">Next</button>
      </div>
    </form>
  </main>
  <script>
    // DEBUG Stampa il post_id nella console
    var postId = '<?php echo $post_id; ?>';
    console.log('Post ID:', postId);
  </script>
</body>
</html>
