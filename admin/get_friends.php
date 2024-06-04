<?php 
include("./../server/connection.php");
include("functions.php");

if(isset($_POST['search'])) {
  $input = $_POST['search'];
  $result = getProfile($conn, $input);

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $photoSrc = $row['photo_name'] ? './../uploads/photos/profile/' . $row['photo_name'] : '../assets/icons/profile.svg';
      $profileUrl = './../public/profilepage.php?user_id=' . $row['id'];
      echo "<div class='search-output'>
              <img src='".$photoSrc."' alt='Profile Picture'>
              <p><a href='".$profileUrl."'>".$row['name']." ".$row['surname']."</a></p>
              </div>
              <div class='line-container'></div>";
    }
  } else {
    echo "<p class='empty-container'>No users found</p>";
  }
}