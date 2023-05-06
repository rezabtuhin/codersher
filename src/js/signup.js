const forms = document.querySelector(".forms"),
  pwShowHide = document.querySelectorAll(".eye-icon"),
  links = document.querySelectorAll(".link");

pwShowHide.forEach((eyeIcon) => {
  eyeIcon.addEventListener("click", () => {
    let pwFields =
      eyeIcon.parentElement.parentElement.querySelectorAll(".password");

    pwFields.forEach((password) => {
      if (password.type === "password") {
        password.type = "text";
        eyeIcon.classList.replace("bx-hide", "bx-show");
        return;
      }
      password.type = "password";
      eyeIcon.classList.replace("bx-show", "bx-hide");
    });
  });
});

links.forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault(); //preventing form submit
    forms.classList.toggle("show-signup");
  });
});

var uerrCheck = 0;
var eerrCheck = 0;
var perrCheck = 0;
var cperrCheck = 0;
function checkForUser() {
  $.ajax({
    type: "POST",
    url: "./logic/userCheck.php",
    data: "username=" + $("#username").val(),
    success: function (response) {
      $("#uError").html(response);
      if (
        response === "Username already taken. Try another one." ||
        response === "Username should not contain spaces."
      ) {
        uerrCheck = 1;
      } else {
        uerrCheck = 0;
      }
    },
  });
}

function checkForEmail() {
  $.ajax({
    type: "POST",
    url: "./logic/userCheck.php",
    data: "email=" + $("#email").val(),
    success: function (response) {
      $("#eError").html(response);
      if (
        response === "Email should not contain spaces." ||
        response === "Email already taken. Try another one."
      ) {
        eerrCheck = 1;
      } else {
        eerrCheck = 0;
      }
    },
  });
}

function checkPass() {
  const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]*$/;
  const value = $("#password").val();
  if (regex.test(value) && value.length >= 8 && value.length <= 50) {
    perrCheck = 0;
    $("#pError").html("Strong Password");
    const perr = document.getElementById("pError");
    perr.style.color = "green";
  } else {
    $("#pError").html("Must be combination of alphanumeric and special chars.");
    const perr = document.getElementById("pError");
    perr.style.color = "#8a202e";
    perrCheck = 1;
  }
}

function checkConPass() {
  const value = $("#password").val();
  const value2 = $("#cpassword").val();
  if (value !== value2) {
    $("#cpError").html("Password didn't match.");
    cperrCheck = 1;
  } else {
    $("#cpError").html("");
    cperrCheck = 0;
  }
}

$(document).ready(function () {
  setInterval(function () {
    if (
      eerrCheck === 1 ||
      uerrCheck === 1 ||
      perrCheck === 1 ||
      cperrCheck === 1
    ) {
      $("#submit").prop("disabled", true);
    } else {
      $("#submit").prop("disabled", false);
    }
  }, 100);
});
