<?php
// Include your database connection here
include "includes/conn.php";
include_once "send-email.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["establishment_id"])) {
    $establishmentId = $_POST["establishment_id"];

    // Get the establishment's details
    $sql = "SELECT * FROM account_establishment WHERE id = $establishmentId";
    $result = mysqli_query($conn, $sql);
    $establishment = mysqli_fetch_assoc($result);

    // Get the owner's details
    $ownerId = $establishment["owner_id"];
    
    // Send an email to the owner
    $to = $owner["email"];
    $subject = "Establishment Declined";
    $type = "Establishment Declined";
    $message = "Your establishment has been declined. Please check your dashboard for more details.";
    $topic = "Establishment Declined";
    $datetime = date("Y-m-d H:i:s");
    $sender = "Geo Boarder Team";

    sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);

    // Update the status of the establishment to "declined" in the database
    $sql = "DELETE FROM account_establishment WHERE id = $establishmentId";

    if (mysqli_query($conn, $sql)) {
        // Return a success response
        echo "Establishment declined successfully";

    } else {
        // Return an error response
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle invalid or missing data
    echo "Invalid request";
}
?>
