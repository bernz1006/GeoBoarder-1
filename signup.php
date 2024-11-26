<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GeoBoarder | Registration Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
<style>
    body {
      background-image: url('images/Background.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }
  </style>
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Geo</b>Boarder</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register your apartment</p>
                <?php
include 'includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST["password"]), PASSWORD_DEFAULT);
    $name = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $price = mysqli_real_escape_string($conn, $_POST["starting_price"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $map = mysqli_real_escape_string($conn, $_POST["map"]);
    $contact = mysqli_real_escape_string($conn, $_POST["contact"]);
    $type = mysqli_real_escape_string($conn, $_POST["type"]);
    $payment_details = mysqli_real_escape_string($conn, $_POST["payment_details"]);
    $type_option = mysqli_real_escape_string($conn, $_POST["type-option"]);
    $near = mysqli_real_escape_string($conn, $_POST["near"]);

    // Handle file upload for "Image of apartment"
    $target_dir = "uploads/";
    $target_file_cover = $target_dir . basename($_FILES["cover_photo"]["name"][0]);

    if (move_uploaded_file($_FILES["cover_photo"]["tmp_name"][0], $target_file_cover)) {
        // File uploaded successfully
    } else {
        die("<div class='alert alert-danger'>Error uploading 'Image of apartment' file.</div>");
    }

    // Handle file upload for "Permit"
    $target_file_permit = $target_dir . basename($_FILES["permit_file"]["name"]);

    if (move_uploaded_file($_FILES["permit_file"]["tmp_name"], $target_file_permit)) {
        // File uploaded successfully
    } else {
        die("<div class='alert alert-danger'>Error uploading 'Permit' file.</div>");
    }

    // Insert data into the database using prepared statements
    $status = "pending"; // Default status
    $sql = "INSERT INTO account_establishment (email, password, name, address, map, cover_photo, permit_file, price, status, contact, payment_details, type, type_option, near) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("<div class='alert alert-danger'>Error preparing statement: " . mysqli_error($conn) . "</div>");
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssssssssss", $email, $password, $name, $address, $map, $target_file_cover, $target_file_permit, $price, $status, $contact, $payment_details, $type, $type_option, $near);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // get the id of inserted data
        $last_id = mysqli_insert_id($conn);

        // upload the video to room_videos/id of the apartment
        // $target_dir = "uploads/room_videos/" . $last_id . "/";
        // $target_file_video = $target_dir . basename($_FILES["video"]["name"]);
        // // Check if the directory exists
        // if (!file_exists($target_dir)) {
        //     mkdir($target_dir, 0777, true);
        // }

        // // Upload the video
        // if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file_video)) {
        //     // File uploaded successfully
        // } else {
        //     die("<div class='alert alert-danger'>Error uploading 'Video of apartment' file.</div>");
        // }
        echo "<div class='alert alert-success'>Data inserted successfully.</div>";
    } else {
        die("<div class='alert alert-danger'>Error inserting data: " . mysqli_error($conn) . "</div>");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Full name" name="fullname" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <!-- Contact number -->
                        <input type="text" class="form-control" placeholder="Contact number" name="contact" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password" name="conf_password"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <!-- Starting price of apartment -->
                        <input type="text" class="form-control" placeholder="Starting price of apartment"
                            name="starting_price" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-money-bill"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Details textarea-->
                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="Payment Details eg. GCASH - 09********* M.R"
                            name="payment_details" required rows="3"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-money-check-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <!--google map link -->
                        <input type="text" class="form-control" placeholder="Google Map Link" name="map" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-marker-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <!-- Address of apartment -->
                        <input type="text" class="form-control" placeholder="Address of apartment" name="address"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-marked-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-control" name="type" id="apartmentType" required>
                            <option value="" disabled selected hidden>Type of Apartment</option>
                            <option value="short-term">Short Term</option>
                            <option value="long-term">Long Term</option>
                            <option value="short-long-term">Short & Long Term</option>
                        </select>
                    </div>

                    <!-- Type Options (hidden by default) -->
                    <div class="input-group mb-3" id="typeOption">
                        <!-- This will be dynamically filled -->
                    </div>

                    <!-- Add radio button to check if this building is near in any university/any school institution -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Near in any university/any school institution?</span>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio1" name="near" value="yes"
                                required>
                            <label for="customRadio1" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio ml-3">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="near" value="no"
                                required>
                            <label for="customRadio2" class="custom-control-label">No</label>
                        </div>
                    </div>

                    <small class="text-muted">Upload permit document</small>
                    <div class="input-group mb-3">
                        <!-- Permit document -->
                        <input type="file" class="form-control" placeholder="Permit document" name="permit_file"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-file"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Upload image of apartment</small>
                    <div class="input-group mb-3">
                        <!-- Image of apartment -->
                        <input type="file" class="form-control" placeholder="Image of apartment" name="cover_photo[]"
                            multiple required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-image"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Upload video of apartment -->
                    <!-- <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Video of apartment" name="video" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-video"></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <button type="submit" class="btn btn-outline-success btn-block">Register</button>
                    </div>
                    <!-- /.col -->
            </div>
            </form>
            <a href="login.php" class="text-center">I already have a account!</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
    </div>

    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function () {
            // Hide the type option by default
            $("#typeOption").hide();

            // Show the type option when the apartment type is selected
            $("#apartmentType").change(function () {
                $("#typeOption").show();
            });

            // Hide the type option when the apartment type is not selected
            $("#apartmentType").blur(function () {
                if ($("#apartmentType").val() == "") {
                    $("#typeOption").hide();
                }
            });

            // Populate the type option based on the apartment type selected
            $("#apartmentType").change(function () {
                var type = $("#apartmentType").val();
                var typeOption = $("#typeOption");

                // Clear the type option
                typeOption.empty();

                // Populate the type option
                if (type == "short-term") {
                    typeOption.append("<select class='form-control' name='type-option' required><option value='' disabled selected hidden>Type Option</option><option value='transient'>Transient</option></select>");
                } else if (type == "long-term") {
                    typeOption.append("<select class='form-control' name='type-option' required><option value='' disabled selected hidden>Type Option</option><option value='apartment'>Apartment</option><option value='dormitory'>Dormitory</option></select>");
                } else if (type == "short-long-term") {
                    typeOption.append("<select class='form-control' name='type-option' required><option value='' disabled selected hidden>Type Option</option><option value='transient'>Transient</option><option value='dormitory'>Dormitory</option><option value='apartment'>Apartment</option></select>");
                }
            });
        });
    </script>
</body>

</html>