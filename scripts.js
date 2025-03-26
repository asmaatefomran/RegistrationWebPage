
function togglePassword() {
  var x = document.getElementById("psw");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}


function toggleConfirmPassword() {
  var x = document.getElementById("confirm_psw");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

myInput.onkeyup = function() {

  var lowerCaseLetters = /[a-z]/g;
  if (myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }

  var upperCaseLetters = /[A-Z]/g;
  if (myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }


  var numbers = /[0-9]/g;
  if (myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

 
  if (myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}

function validateForm() {
  var isValid = true;
  var inputs = document.querySelectorAll("input[type='text'], input[type='password'], input[type='file']");
  inputs.forEach(function(input) {
    if (input.value.trim() === "") {
      input.classList.add("error-field");
      isValid = false;
    } else {
      input.classList.remove("error-field");
    }
  });

  if (!isValid) {
    document.getElementById("global-error").style.display = "block";
    document.getElementById("global-error").textContent = "You must fill in all of the form fields.";
  } else {
    document.getElementById("global-error").style.display = "none";
  }

  return isValid;


  
}

$(document).ready(function() {
  // AJAX for username validation
  $("#username").keyup(function() {
      let username = $(this).val();
      if (username.length > 2) {
          $.ajax({
              url: 'DB_Ops.php',
              type: 'POST',
              data: {validate: 'username', username: username},
              success: function(response) {
                  $("#usernameValidation").html(response);
              }
          });
      } else {
          $("#usernameValidation").html('');
      }
  });

  // AJAX for email validation
  $("#email").keyup(function() {
      let email = $(this).val();
      if (email.length > 5) {
          $.ajax({
              url: 'DB_Ops.php',
              type: 'POST',
              data: {validate: 'email', email: email},
              success: function(response) {
                  $("#emailValidation").html(response);
              }
          });
      } else {
          $("#emailValidation").html('');
      }
  });
});

