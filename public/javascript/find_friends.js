$(document).ready(function () {
  $("#search").keyup(function () {
    var input = $(this).val();

    if (input != "") {
      $.ajax({
        url: "./../admin/get_friends.php",
        method: "POST",
        data: { search: input },
        success: function (data) {
          $("#search-result").html(data);
          $("#search-result").css('display', 'block');
        },
      });
    } else {
      $("#search-result").css("display", "none");
    }
  });
});