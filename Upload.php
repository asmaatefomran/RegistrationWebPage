<?php
function uploadImage() {
    // Check if image file is uploaded
    if(isset($_FILES["user_image"]) && $_FILES["user_image"]["error"] == 0) {
        $target_dir = "uploads/";
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Check file size (max 5MB)
        if ($_FILES["user_image"]["size"] > 5000000) {
            $_SESSION['error-msg'] = "Sorry, your file is too large (max 5MB).";
            header("Location: index.php");
            exit();
        }
        
        // Allow certain file formats
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($file_extension, $allowed_types)) {
            $_SESSION['error-msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: index.php");
            exit();
        }
        
        // Try to upload file
        if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
            return $new_filename; // Return the new filename to be stored in DB
        } else {
            $_SESSION['error-msg'] = "Sorry, there was an error uploading your file.";
            header("Location: index.php");
            exit();
        }
    }
    return null; // Return null if no file was uploaded
}
?>