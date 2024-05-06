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

// Get the establishment ID of the logged-in user
$id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_name = $_POST['room_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $max_tenant = $_POST['max_tenant'];
    // remove the empty values from the array
    $features = array_filter($_POST['features']);
    $features = implode(',', $features);
    $near = $_POST['near'];

    // Insert room data into the database
    $sql = "INSERT INTO rooms (room_name, description, price, max, features, establishment_id)
            VALUES ('$room_name', '$description', '$price', '$max_tenant', '$features', $id)";

    if (mysqli_query($conn, $sql)) {
        // Get the room_id of the inserted record
        $room_id = mysqli_insert_id($conn);

        // Create a directory for the room's images based on room_id
        $targetDirectory = "room_images/" . $room_id . "/";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        // Upload room images
        $targetFiles = [];
        foreach ($_FILES["room_images"]["name"] as $key => $name) {
            $targetFiles[] = $targetDirectory . basename($name);
        }

        $uploadSuccess = true;
        foreach ($_FILES["room_images"]["tmp_name"] as $key => $tmp_name) {
            if (!move_uploaded_file($tmp_name, $targetFiles[$key])) {
                // Error uploading one or more images
                $uploadSuccess = false;
                break;
            }
        }

        if ($uploadSuccess) {
            // Images uploaded successfully, now update the database with image paths
            $imagePath = implode(',', $targetFiles);

            $updateSql = "UPDATE rooms SET image_path = '$imagePath' WHERE room_id = $room_id";

            if (mysqli_query($conn, $updateSql)) {
                // Room and images added successfully
                header("Location: roomlist.php"); // Redirect to the room list page
                exit();
            } else {
                // Error updating image paths in the database
                echo "Error updating image paths: " . mysqli_error($conn);
            }
        } else {
            // Error uploading one or more images
            echo "Error uploading images.";
        }
    } else {
        // Error inserting data into the database
        echo "Error inserting room data: " . mysqli_error($conn);
    }
}
?>
