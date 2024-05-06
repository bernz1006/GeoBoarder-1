<?php
// Include your database connection here
include "includes/conn.php";
include_once "send-email.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["room_id"])) {
    $room_id = $_POST["room_id"];
    $dateTimeNow = date("Y-m-d H:i:s");
    
    // Update the room's status to "approved" in the database
    $sql = "UPDATE reservations SET status = 'approved' WHERE id = $room_id";
    
    if (mysqli_query($conn, $sql)) {
        // Room approved successfully
        echo "Room approved";

        // Get the room's details
        $sql = "SELECT * FROM reservations WHERE id = $room_id";
        $result = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($result);

        // Get the tenant's details
        $name = $room["name"];
        $email = $room["email"];
        $room_ids = $room["room_id"];

        // get room details
        $sql = "SELECT * FROM rooms WHERE room_id = $room_ids";
        $result = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($result);

        $room_name = $room["room_name"];
        $room_price = $room["price"];
        // format price to currency
        $room_price = number_format($room_price, 2, '.', ',');
        $room_description = $room["description"];
        
        // Send an email to tenant with the details of room
        $to = $email;
        $subject = "Room Reservation Approved";
        $type = "Room Reservation Approved";
        $message = "Your room reservation has been approved. <br> <br> Room Name: $room_name <br> Room Price: $room_price <br> Room Description: $room_description <br> <br> Please check your dashboard for more details.";
        $topic = "Room Reservation Approved";
        $datetime = date("Y-m-d H:i:s");
        $sender = "Geo Boarder Team";

        sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);
    } else {
        // Error approving the room
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Invalid request
    echo "Invalid request";
}
?>
