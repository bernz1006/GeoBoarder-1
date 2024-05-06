<?php
// Include your database connection here
include "includes/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["establishment_id"])) {
    $establishmentId = $_POST["establishment_id"];

    // Update the status of the establishment to "declined" in the database
    $sql = "UPDATE account_establishment SET status = 'declined' WHERE id = $establishmentId";

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
