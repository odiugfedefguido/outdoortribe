<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");
$user_data = checkLogin($conn);
$user_id = $user_data['id'];
?>

<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
  <link rel="stylesheet" href="styles/find_friends.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Find Friends</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <h1>Find your Friends</h1>
    <div class="form-container">
      <form action="" id="search-form" method="post">
        <label for="friend-name">Name and Surname</label>
        <div class="search-box">
          <input type="text" id="friend-name" name="friend-name" placeholder="Search" required>
          <button type="submit">
            <img src="../assets/icons/search-alt.svg" alt="Search">
          </button>
        </div>
      </form>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>
</body>
</html>