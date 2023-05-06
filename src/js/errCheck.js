$(document).ready(function () {
  $(".check_uname").keyup(function (e) {
    var uname = $(".check_uname").val();
    $.ajax({
      type: "POST",
      url: "./logic/unameerrCheck.php",
      data: { check_uname_btn: 1, uname: uname },
      success: function (response) {
        if (response == "Username already taken. Try another one.") {
          $(".check_uname").text(response);
          $(".regibtn").attr("disabled", true);
        } else if (response == "Username should not contain spaces.") {
          $(".check_uname").text(response);
          $(".regibtn").attr("disabled", true);
        } else {
          $(".unameerr").text(response);
          $(".regibtn").attr("disabled", false);
        }
      },
    });
  });
});

$(document).ready(function () {
  $(".check_email").keyup(function (e) {
    var email = $(".check_email").val();
    console.log(email);
    $.ajax({
      type: "POST",
      url: "./logic/emailerrCheck.php",
      data: { check_email: 1, email: email },
      success: function (response) {
        if (response == "Email already in use.") {
          $(".emailerr").text(response);
          $(".regibtn").attr("disabled", true);
        } else {
          $(".emailerr").text(response);
          $(".regibtn").attr("disabled", false);
        }
      },
    });
  });
});
