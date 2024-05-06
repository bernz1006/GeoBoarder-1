<?php 

include('../includes/conn.php');

$id = $_POST['id'];

$sql = "SELECT room_id FROM rooms WHERE establishment_id = $id";
$result = mysqli_query($conn, $sql);

// check if numrows
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $room_id = $row['room_id'];

        $sql = "SELECT * from reservations where room_id = $room_id and status = 'pending'";
        $result2 = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            while( $row2 = mysqli_fetch_assoc($result2)) {
                $name = $row2["name"];
                $contact = $row2["contact"];
                $email = $row2["email"];
                $address = $row2["address"];
                $selfie_file = $row2["selfie_file"];
                $reservation_date = $row2["reservation_date"];
                $valid_id_file = $row2["valid_id_file"];

                // put to array
                $data[] = array(
                    'name' => $name,
                    'contact' => $contact,
                    'email' => $email,
                    'address' => $address,
                    'selfie_file' => $selfie_file,
                    'reservation_date' => $reservation_date,
                    'valid_id_file' => $valid_id_file
                );
            }
        }
    }
} else {
    // send empty array
    $data = array();
}

// return json
echo json_encode($data);