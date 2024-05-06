<?php
// Include your database connection here
include "includes/conn.php";
include "send-email.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["establishment_id"])) {
    $establishmentId = $_POST["establishment_id"];

    // Update the status of the establishment to "approved" in the database
    $sql = "UPDATE account_establishment SET status = 'approved' WHERE id = $establishmentId";

    if (mysqli_query($conn, $sql)) {
        // Return a success response
        echo "Establishment approved successfully";

        // Get the establishment's details
        $sql = "SELECT * FROM account_establishment WHERE id = $establishmentId";
        $result = mysqli_query($conn, $sql);
        $establishment = mysqli_fetch_assoc($result);

        // Get the owner's details
        $name = $establishment["name"];
        $email = $establishment["email"];

        // Send an email to the owner
        $to = $email;
        $subject = "Establishment Approved";
        $type = "Establishment Approved";
        $message = "Your establishment has been approved. Please check your dashboard for more details.";
        $topic = "Establishment Approved";
        $datetime = date("Y-m-d H:i:s");
        $sender = "Geo Boarder Team";

        sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);
    } else {
        // Return an error response
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle invalid or missing data
    echo "Invalid request";
}
?>
