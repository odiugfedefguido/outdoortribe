<!-- Contenitore del post -->
<div class="post-container">
  <!-- Contenitore del nome utente -->
  <div class="username-container">
    <!-- Immagine del profilo dell'utente -->
    <img class="user-picture" src="<?php echo $profile_photo_url; ?>" alt="username-picture">
    <!-- Nome utente -->
    <p class="username"><?php echo $username; ?></p>
  </div>
  <!-- Contenitore della foto -->
  <div class="photo-container">
    <!-- Mappa o immagine del post -->
    <div class="map">
      <img src="./../assets/icons/map.svg" alt="post-picture">
    </div>
  </div>
  <!-- Contenitore delle informazioni -->
  <div class="info-container">
    <!-- Titolo del post -->
    <div class="title">
      <!-- Se non è la pagina dei dettagli del post, il titolo è un link -->
      <?php if (!$is_post_details) : ?>
        <h2><a href="post_details.php?id=<?php echo $post_id; ?>"><?php echo $title; ?></a></h2>
      <?php else : ?>
        <!-- Altrimenti, il titolo è testo normale -->
        <h2><?php echo $title; ?></h2>
      <?php endif; ?>
    </div>
    <!-- Luogo del post -->
    <div class="location">
      <img src="./../assets/icons/location.svg" alt="location-icon">
      <p><?php echo $location; ?></p>
    </div>
    <!-- Attività del post -->
    <div class="activity">
      <img src="./../assets/icons/activity.svg" alt="activity-icon">
      <p><?php echo $activity; ?></p>
    </div>
    <!-- Dettagli dell'attività -->
    <div class="details-container">
      <!-- Durata -->
      <div class="duration">
        <img src="./../assets/icons/time.svg" alt="duration-activity-icon">
        <p><?php echo $duration; ?></p>
      </div>
      <!-- Lunghezza -->
      <div class="length">
        <img src="./../assets/icons/length.svg" alt="length-activity-icon">
        <p>Km:<?php echo $length; ?></p>
      </div>
      <!-- Altitudine -->
      <div class="altitude">
        <img src="./../assets/icons/altitude.svg" alt="altitude-activity-icon">
        <p><?php echo $altitude; ?></p>
      </div>
      <!-- Difficoltà -->
      <div class="difficulty-<?php echo strtolower($difficulty); ?>">
        <p><?php echo $difficulty; ?></p>
      </div>
    </div>
    <!-- Valutazione e mi piace -->
    <div class="rating-likes">
      <!-- Valutazione -->
      <div class="rating">
        <!-- Visualizza le stelle piene -->
        <?php for ($i = 0; $i < $full_stars; $i++) { ?>
          <img src="./../assets/icons/star.svg" alt="rating-icon">
        <?php
        }
        // Se c'è una mezza stella, visualizzala
        if ($half_star) {
        ?>
          <img src="./../assets/icons/half-star.svg" alt="rating-icon">
        <?php
        }
        ?>
        <!-- Visualizza il rating -->
        <p> <?php echo number_format($average_rating, 1); ?> </p>
      </div>
      <!-- Mi piace -->
      <div class="likes">
        <!-- Conteggio dei mi piace -->
        <p id="likes-<?php echo $post_id; ?>" data-post-id="<?php echo $post_id; ?>" class="likes-count"><?php echo $likes; ?></p>
        <!-- Icona del mi piace -->
        <div class="<?php echo $like_icon_class; ?>" data-post-id="<?php echo $post_id; ?>"></div>
      </div>
    </div>
  </div>
</div>