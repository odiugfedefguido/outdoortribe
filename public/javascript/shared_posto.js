function sharePost(postId) {
    $.ajax({
      url: './../admin/share-post.php',
      type: 'POST',
      data: { post_id: postId },
      success: function(response) {
        
          window.location.href = './../public/shared_photo.php?post_id=' + postId;
      }
    });
  }
  