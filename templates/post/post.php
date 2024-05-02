<div class="post-container">
  <div class="username-container">
    <img class="user-picture" src="<?php echo $profile_photo_url; ?>" alt="username-picture">
    <p class="username"><?php echo $username; ?></p>
  </div>
  <div class="photo-container">
    <div class="map">
      <img src="./../assets/icons/map.svg" alt="post-picture">
    </div>
  </div>
  <div class="info-container">
    <div class="title">
      <?php if (!$is_post_details) : ?>
        <h2><a href="post_details.php?id=<?php echo $post_id; ?>"><?php echo $title; ?></a></h2>
      <?php else : ?>
        <h2><?php echo $title; ?></h2>
      <?php endif; ?>
    </div>
    <div class="location">
      <img src="./../assets/icons/location.svg" alt="location-icon">
      <p><?php echo $location; ?></p>
    </div>
    <div class="activity">
      <img src="./../assets/icons/activity.svg" alt="activity-icon">
      <p><?php echo $activity; ?></p>
    </div>
    <div class="details-container">
      <div class="duration">
        <img src="./../assets/icons/time.svg" alt="duration-activity-icon">
        <p><?php echo $duration; ?></p>
      </div>
      <div class="length">
        <img src="./../assets/icons/length.svg" alt="length-activity-icon">
        <p>Km:<?php echo $length; ?></p>
      </div>
      <div class="altitude">
        <img src="./../assets/icons/altitude.svg" alt="altitude-activity-icon">
        <p><?php echo $altitude; ?></p>
      </div>
      <div class="difficulty-<?php echo strtolower($difficulty); ?>">
        <p><?php echo $difficulty; ?></p>
      </div>
    </div>
    <div class="rating-likes">
      <div class="rating">
        <?php for ($i = 0; $i < $rating; $i++) { ?>
          <img src="./../assets/icons/star.svg" alt="rating-icon">
        <?php } ?>
      </div>
      <div class="likes">
        <p  id="likes-<?php echo $post_id; ?>" class="likes-count"><?php echo $likes; ?></p>
        <div class="<?php echo $like_icon_class; ?>" data-post-id="<?php echo $post_id; ?>"></div>
      </div>
    </div>
  </div>
</div>