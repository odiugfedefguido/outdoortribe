<?php
  session_start();
  include ("./../server/connection.php");
  include ("./../server/functions.php");
  
  //$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomePage</title>
  <link rel="stylesheet" href="./../templates/styles/header.css">
  <link rel="stylesheet" href="./../templates/styles/footer.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include('./../templates/header.html'); ?>
<main>
  <div id="post-container">
    <?php
      // // Assicurati di avere l'ID dell'utente corrente (supponiamo sia 1 per esempio)
      // $current_user_id = 1;

      // // Query per ottenere i post delle persone che segui
      // $query = "SELECT p.title, p.content 
      //           FROM posts p 
      //           INNER JOIN follows f ON p.user_id = f.followed_id 
      //           WHERE f.follower_id = $current_user_id";
      // $result = $conn->query($query);

      // // Mostra i post
      // if ($result->num_rows > 0) {
      //     while($row = $result->fetch_assoc()) {
      //         echo "<div class='post'>";
      //         echo "<h2>" . $row["title"] . "</h2>";
      //         echo "<p>" . $row["content"] . "</p>";
      //         echo "</div>";
      //     }
      // } else {
      //     echo "Nessun post disponibile";
      // }
      // $conn->close();
    ?>
  </div>
</main>
<?php include('./../templates/footer.html'); ?>
</body>
</html>