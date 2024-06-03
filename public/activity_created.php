<?php
session_start();
include("./../server/connection.php");
include("./../admin/functions.php");
checkLogin($conn);

// Segna il post come creato nella sessione
$_SESSION['post_created'] = true;

// Una volta che l'attività è stata creata, rimuovi il post_id dalla sessione
unset($_SESSION['post_id']);
?>

<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="/outdoortribe/templates/footer/footer.css">
  <link rel="stylesheet" href="/outdoortribe/templates/header/header.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="stylesheet" href="./styles/activity_created.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Activity Created</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <h1>Activity Created!</h1>
    <div class="images-container">
      <img src="./../assets/icons/fireworks.svg" alt="fireworks-image">
      <img src="./../assets/icons/mountain.svg" alt="mountain-image">
    </div>  
    <div class="message-container">
      <p><span>OutdoorTribe</span> thanks you for growing the activity database!</p>
      <p>Thank you for your support</p>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
  <script>
    setTimeout(function() {
      window.location.href = "homepage.php"; // Modifica l'URL della homepage se necessario
    }, 2500);
  </script>
</body>
</html>