<?php include 'header.php';
include 'DB_Ops.php';
$fullnameErr = $usernameErr = $emailErr = $phoneErr = $whatsappErr = $addressErr = $passwordErr = $confirmPasswordErr = $imageErr = "";
$fullname = $username = $email = $phone = $whatsapp = $address = "";
$globalError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $hasError = false;


  if (empty($_POST["fullname"])) {
    $fullnameErr = "";
    $hasError = true;
  } else {
    $fullname = test_input($_POST["fullname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
      $fullnameErr = "Only letters and spaces are allowed";
      $hasError = true;
    }
  }

  // Validate username
  if (empty($_POST["username"])) {
    $usernameErr = "";
    $hasError = true;
  } else {
    $username = test_input($_POST["username"]);
    if (!preg_match("/^\S*$/", $username)) {
      $usernameErr = "Username must not contain spaces";
      $hasError = true;
    }
  }

  // Validate email
  if (empty($_POST["email"])) {
    $emailErr = "";
    $hasError = true;
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $hasError = true;
    }
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "";
    $hasError = true;
  } else {
    $phone = test_input($_POST["phone"]);
    if (!preg_match('/^[0-9]{11}$/', $phone)) {
      $phoneErr = "Invalid Phone Number";
      $hasError = true;
    }
  }


  if (empty($_POST["whatsapp"])) {
    $whatsappErr = "";
    $hasError = true;
  } else {
    $whatsapp = test_input($_POST["whatsapp"]);
    if (!preg_match('/^[0-9]{11}$/', $whatsapp)) {
      $whatsappErr = "Invalid WhatsApp Number";
      $hasError = true;
    }
  }


  if (empty($_POST["address"])) {
    $addressErr = "";
    $hasError = true;
  } else {
    $address = test_input($_POST["address"]);
  }


  if (empty($_POST["psw"])) {
    $passwordErr = "";
    $hasError = true;
  } else {
    $password = test_input($_POST["psw"]);
    if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $password)) {
      $passwordErr = "Password must contain at least one number, one uppercase, and one lowercase letter, and be at least 8 characters long.";
      $hasError = true;
    }
  }

  if (empty($_POST["confirm_psw"])) {
    $confirmPasswordErr = "";
    $hasError = true;
  } else {
    $confirmPassword = test_input($_POST["confirm_psw"]);
    if ($confirmPassword !== $_POST["psw"]) {
      $confirmPasswordErr = "Passwords do not match.";
      $hasError = true;
    }
  }

  if (empty($_FILES["user_image"]["name"])) {
    $imageErr = "";
    $hasError = true;
  } else {
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    $file_extension = strtolower(pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_types)) {
      $imageErr = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
      $hasError = true;
    }
  }

  if ($hasError) {
    $globalError = "You must fill in all of the form fields.";
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
  <title>Registration Form</title>
</head>

<body>

  <h2>Register in the Form</h2>

  <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
      <div class="section-header">Contact Information</div>

      <label>Full Name</label>
      <input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" class="<?php echo !empty($fullnameErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $fullnameErr; ?></span>
      <br><br>

      <label>Username</label>
      <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" class="<?php echo !empty($usernameErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $usernameErr; ?></span>
      <br><br>

      <label>E-mail</label>
      <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" class="<?php echo !empty($emailErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $emailErr; ?></span>
      <br><br>

      <label>Phone Number</label>
      <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="<?php echo !empty($phoneErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $phoneErr; ?></span>
      <br><br>

      <label>WhatsApp Number</label>
      <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($whatsapp); ?>" class="<?php echo !empty($whatsappErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $whatsappErr; ?></span>
      <br><br>

      <label>Upload Image</label>
      <input type="file" name="user_image" accept=".jpg, .jpeg, .png, .gif" class="<?php echo !empty($imageErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $imageErr; ?></span>
      <br><br>

      <div class="section-header">Address</div>

      <label>Address</label>
      <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" class="<?php echo !empty($addressErr) ? 'error-field' : ''; ?>">
      <span class="error"><?php echo $addressErr; ?></span>
      <br><br>

      <div class="section-header">Password</div>

      <div class="password-container">
        <div class="password-field">
          <label>Password</label>
          <input type="password" id="psw" name="psw" value="<?php echo htmlspecialchars($_POST["psw"] ?? ''); ?>" class="<?php echo !empty($passwordErr) ? 'error-field' : ''; ?>">
          <div class="show-password">
            <input type="checkbox" onclick="togglePassword()"> Show Password
          </div>
          <span class="error"><?php echo $passwordErr; ?></span>
        </div>
        <div id="message">
          <h3>Password must contain:</h3>
          <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
          <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
          <p id="number" class="invalid">A <b>number</b></p>
          <p id="length" class="invalid">Minimum <b>8 characters</b></p>
        </div>
      </div>
      <br><br>

      <label>Confirm Password</label>
      <input type="password" id="confirm_psw" name="confirm_psw" value="<?php echo htmlspecialchars($_POST["confirm_psw"] ?? ''); ?>" class="<?php echo !empty($confirmPasswordErr) ? 'error-field' : ''; ?>">
      <div class="show-password">
        <input type="checkbox" onclick="toggleConfirmPassword()"> Show Password
      </div>
      <span class="error"><?php echo $confirmPasswordErr; ?></span>
      <br><br>


      <input type="submit" value="Submit">


      <div id="global-error" class="error"><?php echo $globalError; ?></div>
    </form>
  </div>
  <?php include 'footer.php'; ?>
  <script src="scripts.js"></script>
</body>

</html>