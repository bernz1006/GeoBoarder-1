<?php 

include_once 'includes/conn.php';

// get the username password
$username = $_POST['username'];
$password = $_POST['password'];

$response = array();

// check if the username and password is empty
if (empty($username) || empty($password)) {
    $response['success'] = false;
    $response['message'] = "Please fill in all the fields";
    echo json_encode($response);
    exit();
} else {
    // check if the username is in the database
    $sql = "SELECT * FROM reservations WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $sql = "SELECT id FROM reservations WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $response['id'] = $id;
        $response['success'] = true;
        $response['message'] = "Login successful";
        echo json_encode($response);
        exit();
    } else {
        $response['success'] = false;
        $response['message'] = "Login failed";
        echo json_encode($response);
        exit();
    }
}

?>