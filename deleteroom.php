<?php
// Include your database connection here
include "includes/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["room_id"])) {
    $room_id = $_POST["room_id"];
    
    // Perform the deletion of the room in the database
    $sql = "DELETE FROM rooms WHERE room_id = $room_id";
    
    if (mysqli_query($conn, $sql)) {
        // Room deleted successfully
        echo "Room deleted";
    } else {
        // Error deleting the room
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Invalid request
    echo "Invalid request";
}
?>
