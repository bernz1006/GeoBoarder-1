<?php
session_start();

// Include your database connection here
include "includes/conn.php";
include_once "send-email.php";

$establishment_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modal_room_id = $_POST["modal_room_id"];
    $name = sanitizeInput($_POST["name"]);
    $contact = sanitizeInput($_POST["contact"]);
    $email = sanitizeInput($_POST["email"]);
    $address = sanitizeInput($_POST["address"]);
    $username = sanitizeInput($_POST["username"]);
    $password = sanitizeInput($_POST["password"]);
    $establishement_email = $_POST["establishment_email"];
    $establishement_name = $_POST["establishment_name"];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        handleError("Invalid email format");
    }

    // Handle file upload (selfie picture)
    $upload_directory = "uploads/";

    if (isset($_FILES["selfie"]) && $_FILES["selfie"]["error"] == UPLOAD_ERR_OK) {
        $selfie_file = $upload_directory . basename($_FILES["selfie"]["name"]);

        if (move_uploaded_file($_FILES["selfie"]["tmp_name"], $selfie_file)) {
            // File uploaded successfully, continue with the database insertion

            // Handle file upload (valid ID)
            $valid_id_directory = "uploads/valid_id/";
            if (!is_dir($valid_id_directory)) {
                mkdir($valid_id_directory, 0755, true);
            }

            if (isset($_FILES["valid_id"]) && $_FILES["valid_id"]["error"] == UPLOAD_ERR_OK) {
                $valid_id_file = $valid_id_directory . basename($_FILES["valid_id"]["name"]);

                if (move_uploaded_file($_FILES["valid_id"]["tmp_name"], $valid_id_file)) {
                    // Valid ID uploaded successfully, continue with the database insertion

                    // Handle file upload (proof of payment)
                    $proof_of_payment_directory = "uploads/proof_of_payment/";
                    if (!is_dir($proof_of_payment_directory)) {
                        mkdir($proof_of_payment_directory, 0755, true);
                    }

                    if (isset($_FILES["proof_of_payment"]) && $_FILES["proof_of_payment"]["error"] == UPLOAD_ERR_OK) {
                        $proof_of_payment_file = $proof_of_payment_directory . basename($_FILES["proof_of_payment"]["name"]);

                        if (move_uploaded_file($_FILES["proof_of_payment"]["tmp_name"], $proof_of_payment_file)) {
                            // Proof of payment uploaded successfully, continue with the database insertion

                            // Add the proof of payment file directory to the database
                            $sql = "INSERT INTO reservations (room_id, name, contact, email, address, selfie_file, valid_id_file, proof_of_payment_file, username, password)
                                    VALUES ('$modal_room_id', '$name', '$contact', '$email', '$address', '$selfie_file', '$valid_id_file', '$proof_of_payment_file', '$username', '$password')";

                            if ($conn->query($sql) === TRUE) {
                                showSuccessMessage("Your reservation has been submitted.");

                                $subject = "Reservation Request";
                                $type = "reservation";
                                $message = "You have a new reservation request. Please check your dashboard.";
                                $topic = "Reservation Request";
                                $datetime = date("Y-m-d H:i:s");
                                $sender = "Home Finder";
                                
                                sendEmail($establishement_email, $subject, $type, $message, $topic, $datetime, $sender);
                            } else {
                                handleError("Error: " . $sql . "<br>" . $conn->error);
                            }
                        } else {
                            handleError("Failed to upload the proof of payment.");
                        }
                    } else {
                        handleError("No proof of payment was uploaded.");
                    }
                } else {
                    handleError("Failed to upload the valid ID.");
                }
            } else {
                handleError("No valid ID was uploaded.");
            }
        } else {
            handleError("Failed to upload the selfie picture.");
        }
    } else {
        handleError("No selfie picture was uploaded.");
    }
}

function sanitizeInput($input)
{
    // Perform any necessary sanitization here
    $input = htmlspecialchars($input);
    return $input;
}

function handleError($errorMessage)
{
    echo "<script>
        swal.fire({
            title: 'Error: " . $errorMessage . "',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    </script>";
}

function showSuccessMessage($message)
{
    echo "<script>
        swal.fire({
            title: 'Success!',
            text: '" . $message . "',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    </script>";
}
?>



<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <h2 class="text-center display-4 mt-2">Apartment Details</h2>
            <hr />
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-left display-5">Available Rooms:</h3>
                </div>
                <div class="col-md-6">
                    <!-- Add modal button for Add review and feedback for this apartment -->
                    <button type="button" class="btn btn-success float-right" data-toggle="modal"
                        data-target="#loginModal">
                        <i class="fa fa-star"></i> Rate this apartment
                    </button>
                </div>
            </div>
            <div class="row">
                <?php
                // Function to get room images by room ID
                function getRoomImages($room_id)
                {
                    $imageDirectory = "room_images/"; // Adjust the directory path as needed
                    $roomImages = [];

                    // Check if the directory exists
                    $roomDirectory = $imageDirectory . $room_id;
                    if (is_dir($roomDirectory)) {
                        // Get all files in the directory
                        $files = scandir($roomDirectory);

                        // Filter out "." and ".." entries
                        $files = array_diff($files, array('.', '..'));

                        // Add each file to the roomImages array
                        foreach ($files as $file) {
                            $roomImages[] = $file;
                        }
                    }

                    return $roomImages;
                }
                $id = $_GET['id'];
                $result = mysqli_query($conn, "SELECT * FROM rooms WHERE establishment_id = $id");

                $sql = ("SELECT contact, payment_details, map, id, email, name FROM account_establishment WHERE id = $id");
                $result2 = mysqli_query($conn, $sql);
                $row2 = mysqli_fetch_array($result2);
                $contact = $row2['contact'];
                $payment_details = $row2['payment_details'];
                $map = $row2['map'];
                $video_link = "uploads/room_videos/" . $row2['id'] . "";
                $establishment_email = $row2['email'];
                $establishment_name = $row2['name'];

                global $establishement_email;


                $roomCount = mysqli_num_rows($result); // Count the number of available rooms
                
                if ($roomCount > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $room_id = $row['room_id'];
                        $max = $row['max'];
                        $result2 = mysqli_query($conn, "SELECT * FROM reservations WHERE room_id = $room_id AND status = 'approved'");
                        $row2 = mysqli_fetch_array($result2);
                        $count = mysqli_num_rows($result2);
                        $features = $row['features'];
                        $slots_left = $max - $count;
                        $roomImages = getRoomImages($room_id);
                        $imageDirectory = "room_images/" . $room_id . "/"; // Adjust the directory path as needed
                

                        if ($slots_left > 0) {
                            $button = '<a href="#" class="btn btn-block btn-success" onclick="setRoomId(' . $room_id . ')" data-toggle="modal" data-target="#applyModal">Available (' . $slots_left . ')</a>';
                        } else {
                            $button = '<button class="btn btn-block btn-danger" disabled>Full</button>';
                        }

                        echo '<div class="col-md-3 mb-4">';
                        echo '<div class="card">';
                        echo '<div id="roomCarousel' . $room_id . '" class="carousel slide" data-ride="carousel">';
                        echo '<div class="carousel-inner">';

                        // Display room images as carousel items
                        foreach ($roomImages as $index => $image) {
                            $activeClass = ($index === 0) ? 'active' : '';
                            echo '<div class="carousel-item ' . $activeClass . '">';
                            echo '<img src="' . $imageDirectory . $image . '" class="d-block w-100" alt="Room Image" height="280px" width="500px">';
                            echo '</div>';
                        }

                        $features = $row['features'];
                        // loop through each feature and display it
                
                        echo '</div>';
                        echo '<a class="carousel-control-prev" href="#roomCarousel' . $room_id . '" role="button" data-slide="prev">';
                        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                        echo '<span class="sr-only">Previous</span>';
                        echo '</a>';
                        echo '<a class="carousel-control-next" href="#roomCarousel' . $room_id . '" role="button" data-slide="next">';
                        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                        echo '<span class="sr-only">Next</span>';
                        echo '</a>';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '
                                <div class="row justify-content-center">
                                    <h5 class="card-title">' . $row['room_name'] . '</h5>
                                </div>
                                <div class="row">
                                    <p class="card-text col-md-6">
                                        <b><i class="fa fa-dollar-sign"></i></b> ₱' . $row['price'] . ' / month
                                    </p>
                                    <p class="card-text col-md-6">
                                        <b><i class="fa fa-users"></i></b> ' . $row['max'] . ' person(s)<br />
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion" id="featuresAccordion' . $room_id . '">
                                            <div class="card">
                                                <div class="card-header" id="featuresHeading' . $room_id . '">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#featuresCollapse' . $room_id . '" aria-expanded="true" aria-controls="featuresCollapse' . $room_id . '">
                                                            Features <i class="fa fa-chevron-right"></i>
                                                        </button>
                                                    </h2>
                                                </div>

                    <div id="featuresCollapse' . $room_id . '" class="collapse" aria-labelledby="featuresHeading' . $room_id . '" data-parent="#featuresAccordion' . $room_id . '">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                ';

                        $featureIcons = [
                            'Air Conditioned' => 'snowflake',
                            'Wifi' => 'wifi',
                            'Restroom' => 'restroom',
                            'Rice Cooker' => 'rice-cooker',
                            'Washing Machine' => 'washing-machine',
                            'TV' => 'tv',
                            'Refrigerator' => 'square',
                            'Microwave' => 'microwave',
                            'Parking' => 'parking',
                            'CCTV' => 'camera'
                        ];

                        $featuresArray = explode(',', $features);

                        foreach ($featuresArray as $feature) {
                            $feature = trim($feature);

                            if (isset($featureIcons[$feature])) {
                                $iconClass = $featureIcons[$feature];
                                echo '<li><i class="fa fa-' . $iconClass . '"></i> ' . $feature . '</li>';
                            } else {
                                echo '<li><i class="fa fa-cog"></i> ' . $feature . '</li>';
                            }
                        }

                        echo '
                                                </ul>
                                            </div>
                                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    ' . $button . '
                                </div>
                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';

                        echo '</div>'; // Close card-body
                        echo '</div>'; // Close card
                        echo '</div>'; // Close col-md-3
                    }
                } else {
                    echo 'No rooms yet';
                }
                ?>
            </div>
            <hr />
            <div class="row justify-content-center">
                <h3 class="text-center display-5">Location & Video</h3><br />
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $map ?>
                </div>
                <div class="col-md-6">
                    <!-- Display every video in carousel style inside the $video_link -->
                    <div id="videoCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $videoDirectory = $video_link . "/"; // Adjust the directory path as needed
                            $videos = [];

                            // Check if the directory exists
                            if (is_dir($videoDirectory)) {
                                // Get all files in the directory
                                $files = scandir($videoDirectory);

                                // Filter out "." and ".." entries
                                $files = array_diff($files, array('.', '..'));

                                // Add each file to the roomImages array
                                foreach ($files as $file) {
                                    $videos[] = $file;
                                }
                            }

                            // Display room images as carousel items
                            foreach ($videos as $index => $video) {
                                $activeClass = ($index === 0) ? 'active' : '';
                                echo '<div class="carousel-item ' . $activeClass . '">';
                                echo '<video width="75%" height="75%" controls>'; // Set width and height to 75%
                                echo '<source src="' . $videoDirectory . $video . '" type="video/mp4">';
                                echo '</video>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#videoCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only"><i class="fa fa-chevron-left"></i></span>
                        </a>
                        <a class="carousel-control-next" href="#videoCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only"><i class="fa fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <hr />
            <div class="row justify-content-center">
            <?php
$sql = ("SELECT * FROM ratings WHERE establishment_id = $id");
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['rating_id'];
        $sql2 = ("SELECT * FROM reservations WHERE id = $id");
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        
       
        $name = "Anonymous"; 
        $rating = $row['ratings'];
        $feedback = $row['feedback'];

        // get the datetime now temporarily
        $date = date("Y-m-d H:i:s");
        // convert the date to human readable form
        $date = date("F j, Y, g:i a", strtotime($date));

        echo '<div class="col-md-12">';
        echo '<div class="card mb-2">';
        echo '<div class="card-body">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '<p class="text-center"><i class="fa fa-user-circle fa-5x"></i></p>';
        echo '<p class="text-center">' . $name . '</p>';
        echo '</div>';
        echo '<div class="col-md-10">';
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        echo '<p class="text-center"><i class="fa fa-star"></i> ' . $rating . '</p>';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<p class="text-center"><i class="fa fa-calendar"></i> ' . $date . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<p class="text-center">' . $feedback . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="col-md-12">';
    echo '<div class="card mb-2">';
    echo '<div class="card-body">';
    echo '<p class="text-center">No feedbacks yet.</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>
</div>

    <!-- Add this modal structure at the end of your HTML body -->
    <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Apply for Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Place your form here -->
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="establishment_email" value="<?php echo $establishment_email; ?>">
                        <input type="hidden" name="establishment_name" value="<?php echo $establishment_name; ?>">
                        <input type="hidden" id="modal_room_id" name="modal_room_id" value="">
                        <div class="form-group">
                            <label for="name">Contact Number of Owner:</label>
                            <!-- Add a read only input that copyable when clicked -->
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo $contact; ?>" readonly>
                            <small id="contactHelp" class="form-text text-muted"><i>Click to copy.</i></small>
                        </div>
                        <div class="form-group">
                            <label for="name">Payment Details:</label>
                            <!-- Add a read only input that copyable when clicked -->
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo $payment_details; ?>" readonly>
                            <small id="contactHelp" class="form-text text-muted"><i>Click to copy.</i></small>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number:</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                            <small id="contactHelp" class="form-text text-muted"><i>Make sure you enter valid
                                    number.</i></small>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="form-group">
                            <label for="selfie">Selfie Picture with ID (Upload):</label>
                            <input type="file" class="form-control-file" id="selfie" name="selfie" required>
                        </div>

                        <div class="form-group">
                            <label for="selfie">Picture of Valid ID (Upload):</label>
                            <input type="file" class="form-control-file" id="valid_id" name="valid_id" required>
                        </div>

                        <div class="form-group">
                            <label for="proof_of_payment">Proof of Payment (Upload):</label>
                            <input type="file" class="form-control-file" id="proof_of_payment" name="proof_of_payment"
                                required>
                        </div>

                        <!-- Add note here says for authentication for feedback -->


                        <!-- Username password here -->
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                            <!-- add small note here -->
                            <small id="contactHelp" class="form-text text-muted"><i>This authentication will be used for
                                    Feedback and Rating</i></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Reserve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add modal for login button -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Login Tenent Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div id="alert"></div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="login_username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="login_password" name="password" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-success" id="loginBtn">Login</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Feedback modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Add form here -->
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Feedback and Rating for this Apartment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeBtn">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="submitFeedback.php" method="POST">
                        <div class="form-group">
                            <label for="feedback">Feedback:</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <select class="form-control" id="rating" name="rating">
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var establishment_id = <?php echo $establishment_id; ?>;
        function setRoomId(roomId) {
            document.getElementById('modal_room_id').value = roomId;
        }
    </script>


    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
            /* 16:9 aspect ratio */
            overflow: hidden;
            position: relative;
        }

        .img-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Zoom or crop the image to cover the container */
            transition: transform 0.3s ease;
        }

        .card:hover .img-wrapper img {
            transform: scale(1.1);
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 500;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>