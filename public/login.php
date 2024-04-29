<?php
  session_start();
  include ("./../server/connection.php");
  include ("./../server/functions.php");
  
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password)) {
      // Controlla se l'email esiste già nel database
      $sql_check_email = "SELECT * FROM user WHERE email = '$email'";
      $result_check_email = $conn->query($sql_check_email);

      if ($result_check_email->num_rows > 0) {
        $user_data = $result_check_email->fetch_assoc();
        if($user_data['password'] === $password) {
          $_SESSION['user_id'] = $user_data['id'];
          header("Location: homepage.php");
          die;
        }
        echo "wrong name or password";
      } 
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./../templates/header/header.css">
  <link rel="stylesheet" href="./../templates/components/components.css">
  <link rel="stylesheet" href="styles/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <img class="logo" src="./../assets/icons/logo.svg" alt="Logo - OutdoorTribe">
  </header>
  <main class="outer-flex-container">
    <div class="image-container">
      <img class="login-image" src="./../assets/icons/login.svg" alt="login-image">
    </div>
    <form class="form-container" method="post">
      <div class="inner-flex-container">
        <div class="logo-container">
          <img class="logo" src="./../assets/icons/logo.svg" alt="Logo - OutdoorTribe">
        </div>
        <div class="message-container">
          <p class="paragraph-450">Elevate your adventures with OutdoorTribe - where every step is a journey.</p>
          <p class="paragraph-400">Welcome Back, please login to your account</p>
        </div>
        <div class="data-input-container">
          <div class="email">
            <label class="email-label" for="email">Email</label>
            <input class="email-txt" type="email" id="email" name="email" placeholder="mario.rossi@gmail.com" required>
          </div>
          <div class="password">
            <label class="password-label" for="password">Password</label>
            <input class="password-txt" type="password" id="password" name="password" maxlength="12" required>
          </div>
        </div>
        <div class="buttons-container">
          <input class="full-btn" type="submit" id="loginBtn" value="Login">
          <button class="border-btn" id="signupBtn">Sign up</button>
        </div>
      </div>
    </form>
  </main>
  <script src="./javascript/login.js"></script>
</body>
</html>