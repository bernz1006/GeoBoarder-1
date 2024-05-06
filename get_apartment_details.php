<?php 
include_once ('includes/conn.php');
if (isset($_GET['id'])) {
    $apartmentId = $_GET['id'];

    $query = "SELECT * FROM account_establishment WHERE id = $apartmentId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $apartmentDetails = mysqli_fetch_assoc($result);
        echo '<p>Name: ' . $apartmentDetails['name'] . '</p>';
        echo '<p>Address: ' . $apartmentDetails['address'] . '</p>';
        echo '<p>Price: ' . $apartmentDetails['price'] . ' PHP per Month</p>';
        // Add button for viewing the and room list
        echo '<a href="room_list.php?apartment_id=<?php echo $id; ?>" class="btn btn-primary">View</a>';
    } else {
        echo 'Error fetching apartment details';
    }
} else {
    echo 'Apartment ID not provided';
}

mysqli_close($conn);
?>