document.getElementById('followButton').addEventListener('click', function() {
    var form = document.getElementById('followForm');
    var followedId = form.querySelector('input[name="followed_id"]').value;
    var action = this.innerText === 'FOLLOW' ? 'follow' : 'unfollow';
    
    fetch('./../admin/follow_unfollow.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'action=' + action + '&followed_id=' + followedId
    })
    .then(response => response.text())
    .then(data => {
      if (data === 'success') {
        location.reload();
      } else {
        alert('Error: ' + data);
      }
    });
  });