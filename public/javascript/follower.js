$(document).ready(function() {
    $('.unfollow-btn').click(function(e) {
      e.preventDefault();
  
      var followedId = $(this).data('id');
  
      $.ajax({
        type: 'POST',
        url: 'unfollow.php',
        data: {
          followed_id: followedId,
          follower_id: loggedUserId
        },
        success: function(response) {
          if (response == 'success') {
            location.reload();
          } else {
            alert('Failed to unfollow. Please try again.');
          }
        }
      });
    });
  });
  