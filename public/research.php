<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Research</title>
  <link rel="stylesheet" href="./../templates/styles/components.css">
  <link rel="stylesheet" href="./../templates/styles/header.css">
  <link rel="stylesheet" href="./../templates/styles/footer.css">
  <link rel="stylesheet" href="./styles/research.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php include('./../templates/header.html'); ?>
  <main>
    <div class="outer-container">
      <div class="title">
        <h1>Find your next adventure</h1>
      </div>
      <form class="data-input-container" action="">
        <label class="generic-label" for="location">Where?</label>
        <input class="generic-txt" type="text" id="location" placeholder="Location">
        <label class="generic-label" for="activity">Which activity?</label>
        <select class="select" name="activities" id="activity">
          <option value="" selected disabled>Scegli un'attività</option>
          <option value="rosso">Rosso</option>
          <option value="verde">Verde</option>
          <option value="blu">Blu</option>
          <option value="giallo">Giallo</option>
        </select>
        <input class="full-btn" type="submit" value="Search">
      </form>
      <div class="logo-adventure">
        <img src="./../assets/icons/research.svg" alt="adventure-image">
      </div>
    </div>
  </main>
  <?php include('./../templates/footer.html'); ?>
</body>
</html>