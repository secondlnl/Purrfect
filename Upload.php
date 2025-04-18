<?php
include "config.php";
session_start();
// upload.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["profile_pic"]["size"] > 2000000) {
        echo "File is too large.";
        $uploadOk = 0;
    }

    // Allow only certain formats (jpg, png, gif)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif") {
        echo "Only JPG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "File could not be uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            echo "File uploaded successfully.";
            // Store the file path in the database
            // Example MySQL code:
            // Assuming you have a 'users' table with a 'profile_picture' column
            $userId = $_SESSION["id"]; // Example user ID
		  $stmt = $conn->prepare("UPDATE Accounts SET img = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $userId); // Bind parameters
            if ($stmt->execute()) {
                echo "Profile picture updated successfully.";
            } else {
                echo "Error updating profile picture: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error moving uploaded file.";
        }
    }
}

$conn->close(); // Close the connection
header("location: account.php")
?>
