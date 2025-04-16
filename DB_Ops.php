<?php
// Database connection
$serverName = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($serverName, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS RegisterForm";
if ($conn->query($sql) ==true){
    mysqli_select_db($conn, database: "RegisterForm");

    // Create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS User (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(50) NOT NULL,
        user_name VARCHAR(30) NOT NULL UNIQUE,
        email VARCHAR(50) NOT NULL UNIQUE,
        phone VARCHAR(15) NOT NULL,
        whatsapp_number VARCHAR(15),
        image VARCHAR(255),
        address VARCHAR(255),
        password VARCHAR(255) NOT NULL,
        submit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (!$conn->query($sql)) {
        echo "Error creating table: " . $conn->error;
    }
}

if (isset($_POST['validate'])) {
    if ($_POST['validate'] == "username") {
        $username = trim(string: $_POST['username']);
        
        // check if username exists
        $stmt = $conn->prepare("SELECT id FROM User WHERE user_name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
      
        if ($stmt->num_rows > 0) {
            echo "<span style='color:red; font-size: 0.9em;'>Username already exists!</span>";
        }
        exit();
    }

    if ($_POST['validate'] == "email") {
        $email = trim($_POST['email']);
        // check if email exists

        $stmt = $conn->prepare("SELECT id FROM User WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            echo "<span style='color:red; font-size: 0.9em;'>Email already registered!</span>";
        }
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['validate'])) {
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $whatsapp = $_POST["whatsapp"];
    $address = $_POST["address"];
    $password = $_POST["psw"];
    $secure_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Handle image upload
    include 'Upload.php';
    $image_name = uploadImage();

$check_username = $conn->prepare("SELECT id FROM User WHERE user_name = ?");
$check_username->bind_param("s", $username);
$check_username->execute();
$check_username->store_result();

$check_email = $conn->prepare("SELECT id FROM User WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();

if ($check_username->num_rows > 0 && $check_email->num_rows > 0) {
    $_SESSION['error-msg'] = "Both username and email already exist!";
    $_SESSION['error_fields'] = ['username', 'email'];
} elseif ($check_username->num_rows > 0) {
    $_SESSION['error-msg'] = "Username already exists!";
    $_SESSION['error_fields'] = ['username'];
} elseif ($check_email->num_rows > 0) {
    $_SESSION['error-msg'] = "Email already exists!";
    $_SESSION['error_fields'] = ['email'];
}

if (isset($_SESSION['error-msg'])) {
    $_SESSION['form_data'] = $_POST;
    header("Location: index.php");
    exit();
}


    $sql = "INSERT INTO User (full_name, user_name, phone, whatsapp_number, address, password, email, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $query_stmt = $conn->prepare($sql);
    $query_stmt->bind_param("ssssssss", $fullname, $username, $phone, $whatsapp, $address, $secure_password, $email, $image_name);

    if ($query_stmt->execute()) {
        $_SESSION['success-msg'] = "Registration completed successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['error-msg'] = "Error: " . $query_stmt->error;
        $_SESSION['form_data'] = $_POST;
        header("Location: index.php");
        exit();
    }
    $query_stmt->close();
}

mysqli_close($conn);
?>