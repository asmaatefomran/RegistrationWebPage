
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

async function validateForm() {
  let isValid = true;
  const inputs = document.querySelectorAll("input[type='text'], input[type='password'], input[type='file']");
  
  inputs.forEach(function(input) {
    if (input.value.trim() === "" && input.name !== "whatsapp") {
      input.classList.add("error-field");
      isValid = false;
    } else {
      input.classList.remove("error-field");
    }
  });

  const whatsappInput = document.querySelector("input[name='whatsapp']");
  if (whatsappInput.value.trim() === "") {
    whatsappInput.classList.add("error-field");
    isValid = false;
  } else if (isValid) {
    const isWhatsAppValid = await validateWhatsApp();
    if (!isWhatsAppValid) {
      whatsappInput.classList.add("error-field");
      isValid = false;
    }
  }

  const errorElement = document.getElementById("global-error");
  errorElement.style.display = isValid ? "none" : "block";
  errorElement.textContent = isValid ? "" : "Please correct the errors in the form.";

  return isValid;
}

async function submitForm(event) {
  event.preventDefault(); 
  const isValid = await validateForm();
  
  if (isValid) {
      event.target.submit();
  } else {
      document.getElementById("global-error").style.display = "block";
      document.getElementById("global-error").textContent = "Please correct the errors in the form.";
  }
}


$(document).ready(function() {
  //username validation
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

  //email validation
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


 async function valide(){
  const isValid = await validateForm();
  if(isvalite)console.log("done");
  else console.log("not");
}
