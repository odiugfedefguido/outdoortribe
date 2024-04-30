document.addEventListener('DOMContentLoaded', function () {
  document.addEventListener('click', function (event) {
    // Verifica se l'elemento cliccato è un'icona del like
    if (event.target.classList.contains('like-icon')) {
      var postId = event.target.dataset.postId;
      likePost(postId);
    }
  });
});

function likePost(postId) {
  $.ajax({
      url: 'like_post.php',
      type: 'POST',
      data: { postId: postId },
      success: function(response) {
          var responseObj = JSON.parse(response);
          var likeCountElement = $('#likes-' + postId);
          var currentLikes = responseObj.likes;
          likeCountElement.text(currentLikes);

          // Aggiungi o rimuovi la classe 'liked' dall'icona
          var likeIcon = $('.like-icon[data-post-id="' + postId + '"]');
          likeIcon.toggleClass('liked');
      },
      error: function(xhr, status, error) {
          // Gestisci eventuali errori
      }
  });
}

