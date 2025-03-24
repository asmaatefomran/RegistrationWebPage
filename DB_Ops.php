<?php
// connection_to_database
$serverName = "localhost";
$username = "student2";
$password = "password";
$dbname = "user_registration";

$conn = mysqli_connect($serverName, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

//create_table in an existance database 
$sql = "CREATE TABLE IF NOT EXISTS User (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(50) NOT NULL,
    user_name VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    whatsapp_number VARCHAR(15),
    address VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    submit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $whatsapp = $_POST["whatsapp"];
    $address = $_POST["address"];
    $password = $_POST["psw"];
    $Secure_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO User (full_name, user_name, phone, whatsapp_number, address, password, email)
                VALUES ('$fullname', '$username', '$phone', '$whatsapp', '$address', '$Secure_password', '$email')";


    if (mysqli_query($conn, $sql)) {
        // echo "Your submit has been recorded.<br>";
    } else {
        echo "Error  " . $sql . "<br>" . mysqli_error($conn);
    }
    //--------------------------------------------------------
    // to display all table in database
    /*  $sql = "SELECT * FROM User";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=1><tr><th>ID</th><th>Full Name</th><th>Username</th><th>Email</th><th>Phone</th><th>WhatsApp</th><th>Address</th><th>Registration Date</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["full_name"] . "</td><td>" . $row["user_name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["whatsapp_number"] . "</td><td>" . $row["address"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No users found in the database.";
    }*/

    //-----------------------------------------------------

    //select the row that just recorded by username to check validation

    // $sqll = "SELECT * FROM User WHERE user_name = '$username'";
    // $resultt = mysqli_query($conn, $sqll);
    // if (mysqli_num_rows($resultt) > 0) {
    //     $row = mysqli_fetch_assoc($resultt);
    //     echo "ID: {$row['id']}, Full Name: {$row['full_name']}, Username: {$row['user_name']}, Email: {$row['email']}, Phone: {$row['phone']}, WhatsApp: {$row['whatsapp_number']}, Address: {$row['address']}}";
    // }
}
mysqli_close($conn);
