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
  <title>Followed</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/footer/footer.css">
 
  <link rel="stylesheet" href="./styles/followed.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include("./../templates/header/header.html"); ?>

  <main>
  <?php 

$current_user_id = 4; //$_SESSION['user_id'];
//query per ottenere i followed
$query = "SELECT user.name, user.surname, user.id
      FROM user
      JOIN follow ON user.id = follow.followed_id
      WHERE follow.follower_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

//stampo il nuemro di seguiti
echo '<h1>Followed</h1>';
echo '<p>Number of followed: '.$result->num_rows.'</p>';

//stampo i seguiti
while($row = $result->fetch_assoc()) {
    $followed_id = $row['id'];
    $followed_name = $row['name'];
    $followed_surname = $row['surname'];
    //query per ottenere l'immagine del followed
    $query_image = "SELECT name
            FROM photo
            WHERE user_id = ? AND post_id IS NULL";

    $stmt_image = $conn->prepare($query_image);
    $stmt_image->bind_param("i", $followed_id);
    $stmt_image->execute();
    $result_image = $stmt_image->get_result();
    
    // Controllo se esiste un'immagine per il followed
    if ($result_image->num_rows > 0) {
        $photo_profile_row = $result_image->fetch_assoc();
        $photo_profile_url = "./../uploads/photos/profile/" . $photo_profile_row['name'];
    } else {
        // Se non c'è un'immagine per il followed, utilizzo un'immagine predefinita
        $photo_profile_url = "./../assets/icons/profile.svg";
    }

    // Stampo il nome e il cognome del followed
    echo '<div class="followed">';
    echo '<img class= "circular-square-img" src="'.$photo_profile_url.'" alt="Profile photo">';
    echo '<p>'.$followed_name.' '.$followed_surname.'</p>';
    echo '<a href="./profilepage.php?user_id='.$followed_id.'">View profile</a>';
    echo '</div>';




}



$conn->close();
?>


  </main>
  <?php include("./../templates/footer/footer.html"); ?>
</body>

</html>