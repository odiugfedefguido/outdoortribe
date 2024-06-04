<?php 

include("./../server/connection.php");

if(isset($_POST['search'])) {
  $input = $_POST['search'];

  $query = $conn->prepare("SELECT * FROM user WHERE name LIKE ? OR surname LIKE ?");
  $searchTerm = "%$input%";
  $query->bind_param("ss", $searchTerm, $searchTerm);
  $query->execute();
  $result = $query->get_result();


  if($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<div class='search-result'>
              <p>".$row['name']." ".$row['surname']."</p>
            </div>";
    }
  } else {
    echo "<p>No users found</p>";

  }
}