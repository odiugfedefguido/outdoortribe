<!DOCTYPE html>
<html lang="en-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../assets/icons/favicon.svg">
  <link rel="stylesheet" href="/outdoortribe/templates/footer/footer.css">
  <link rel="stylesheet" href="/outdoortribe/templates/header/header.css">
  <link rel="stylesheet" href="styles/createactivity.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Create New Activity</title>
</head>
<body>
  <?php include("./../templates/header/header.html"); ?>
  <main class="outer-flex-container">
    <div class="title-container">
      <h1>Create a new Activity</h1>
    </div>
    <form id="check-form" action="check.php" method="post">
    <div class="form-container">
        <div class="location-container">
          <div class="text-container">
            Which Activity?
          </div>
            <label class="label-hidden" for="location">Location</label>
            <input type="text" id="location" placeholder="Location">
        </div>
        <div class="activity-container">
          <div class="text-container">
            Which Activity?
          </div>
            <label class="label-hidden" for="activity-type">Type of Activity</label>
            <select name="activity-type" id="activity-type" required>
              <option value="" disabled selected hidden>Activity</option>
              <option value="cycling">Cycling</option>
              <option value="trekking">Trekking</option>
              <option value="hiking">Hiking</option> 
            </select>
        </div>
    </div>
    </form>
    <div class="message-container">
      <p>Please, enter coordinates</p>
    </div>
    <div class="image-container">
      <img src="../assets/icons/map.svg" alt="map">
    </div>
    <div class="buttons-container">
      <button id="check-btn" type="submit">Check</button>
    </div>
  </main>
  <?php include("./../templates/footer/footer.html"); ?>

  <script src="./javascript/createactivity.js"></script>

</body>
</html>
