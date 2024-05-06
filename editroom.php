<?php
session_start();

// Check if the user is logged in (has an active session)
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php"); // Replace with the actual login page filename
    exit();
}

// Include your database connection here
include "includes/conn.php";

// Get the email of the logged-in user
$id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = $_POST['room_id'];
    $room_name = $_POST['room_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $max_tenant = $_POST['max_tenant'];
    $features = $_POST['features'];

    // Check if a new image was uploaded
    if ($_FILES["room_image"]["name"]) {
        $uploadDirectory = "uploads/";
        $targetFile = $uploadDirectory . basename($_FILES["room_image"]["name"]);

        if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $targetFile)) {
            // Image uploaded successfully
            $image_path = $targetFile;
        } else {
            // Error uploading the image
            echo "Error uploading image.";
            exit();
        }
    } else {
        // If no new image was uploaded, retain the existing image path
        $image_path = $conn->real_escape_string($_POST['existing_image_path']);
    }

    // Update room details in the database
    $sql = "UPDATE rooms SET room_name = '$room_name', description = '$description', price = '$price', image_path = '$image_path', max = '$max_tenant', features = '$features' WHERE room_id = $room_id";
    
    if (mysqli_query($conn, $sql)) {
        // Room details updated successfully
        header("Location: roomlist.php"); // Redirect to the room list page
        exit();
    } else {
        // Error updating data in the database
        echo "Error: " . mysqli_error($conn);
    }
}
?>
