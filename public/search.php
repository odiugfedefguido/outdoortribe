<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");

//$user_data = checkLogin($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="./styles/research.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php include('./../templates/header/header.html'); ?>
  <main>
    <div class="outer-container">
      <div class="title">
        <h1>Find your next adventure</h1>
      </div>
      <form class="data-input-container" method="get" action="searching.php">
        <label class="generic-label" for="location">Where?</label>
        <input class="generic-txt" type="text" id="location" name="location" placeholder="Location" required>
        <label class="generic-label" for="activity">Which activity?</label>
        <select class="select" name="activity" id="activity" required>
          <option value="" selected disabled>Scegli un'attività</option>
          <?php
          // Query per ottenere i valori univoci della colonna activity
          $activity_query = "SELECT DISTINCT activity FROM post";
          $activity_result = $conn->query($activity_query);

          // Se ci sono attività disponibili, generale le opzioni del menu a discesa
          if ($activity_result->num_rows > 0) {
              while ($row = $activity_result->fetch_assoc()) {
                  $activity_name = $row['activity'];
                  // Stampare ciascuna attività come opzione nel menu a discesa
                  echo "<option value='$activity_name'>$activity_name</option>";
              }
          } else {
              // Nessuna attività disponibile
              echo "<option disabled>Nessuna attività disponibile</option>";
          }
          ?>
        </select>
        <input class="full-btn" type="submit" value="Search">
      </form>
      <div class="logo-adventure">
        <img src="./../assets/icons/research.svg" alt="adventure-image">
      </div>
    </div>
  </main>
  <?php include('./../templates/footer/footer.html'); ?>
</body>
</html>