<?php
// Include your database connection here
include "includes/conn.php";
include_once "send-email.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["room_id"])) {
    $room_id = $_POST["room_id"];
    
    // Update the room's status to "declined" in the database
    $sql = "UPDATE reservations SET status = 'Denied' WHERE id = $room_id AND status = 'pending'";
    
    if (mysqli_query($conn, $sql)) {
        // Room declined successfully
        echo "Room declined";

        // Get the room's details
        $sql = "SELECT * FROM reservations WHERE id = $room_id";
        $result = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($result);

        // Get the tenant's details
        $name = $room["name"];
        $email = $room["email"];

        // Send an email to the tenant
        $to = $email;
        $subject = "Room Reservation Declined";
        $type = "Room Reservation Declined";
        $message = "Your room reservation has been declined. Please check your dashboard for more details.";
        $topic = "Room Reservation Declined";
        $datetime = date("Y-m-d H:i:s");
        $sender = "Geo Boarder Team";

        sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);
    } else {
        // Error declining the room
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Invalid request
    echo "Invalid request";
}
?>
