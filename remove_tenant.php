<?php
// Include your database connection file
include "includes/conn.php";
include_once "send-email.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tenant_id"])) {
    // Sanitize and retrieve the tenant ID from the POST data
    $tenantId = filter_var($_POST["tenant_id"], FILTER_SANITIZE_NUMBER_INT);

    // Perform the SQL query to remove the tenant
    $sql = "DELETE FROM reservations WHERE id = $tenantId";
    if (mysqli_query($conn, $sql)) {
        // Tenant removal was successful
        echo "Tenant removed successfully";

        // Get the tenant's details
        $sql = "SELECT * FROM reservations WHERE id = $tenantId";
        $result = mysqli_query($conn, $sql);
        $tenant = mysqli_fetch_assoc($result);
        
        // Get the tenant's details
        $name = $tenant["name"];
        $email = $tenant["email"];

        // Send an email to the tenant
        $to = $email;
        $subject = "Room Reservation Removed";
        $type = "Room Reservation Removed";
        $message = "Your room reservation has been removed. Please check your dashboard for more details.";
        $topic = "Room Reservation Removed";
        $datetime = date("Y-m-d H:i:s");
        $sender = "Home Finder Team";

        sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);
    } else {
        // Tenant removal failed
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Invalid request or missing tenant ID
    echo "Invalid request or missing tenant ID";
}

// Close the database connection
mysqli_close($conn);
?>
