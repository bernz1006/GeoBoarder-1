<?php
session_start();

// Check if the user is logged in (has an active session)
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php"); // Replace with the actual login page filename
    exit();
}

// Include your database connection here
include "includes/conn.php";

// Get the email of the logged-in user
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Room List</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

</head>

<body class="hold-transition layout-top-nav">
    <style>
        .content-wrapper {
      background-image: url('images/Background.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }
    </style>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-light">
            <div class="container">
                <a href="index3.html" class="navbar-brand">
                    <img src="Geo-Boarder.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">GeoBoarder</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="home_owner.php" class="nav-link">Dashboard</a>
                        </li>
                        <li class="navbar-nav">
                            <a href="roomlist.php" class="nav-link">Room List</a>
                        </li>
                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- logout button -->
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout</a>
                    </li>
                    <!-- /.Login dropdown -->
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Room List</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <h5 class="text-body">Room List</h5><br />
                        <!-- Add room button list -->
                        <!-- Add room button -->
                        <a href="#" class="btn btn-success ml-auto" data-toggle="modal" data-target="#addRoomModal">Add
                            Room</a>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <table id="requestlist" class="table table-hover">
                                <thead>
                                    <th>Room Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Max Tenant</th>
                                    <th>Features</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM rooms where establishment_id = $id";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $room_name = $row['room_name'];
                                            $description = $row['description'];
                                            $price = $row['price'];
                                            $room_image = $row['image_path'];
                                            $max_tenant = $row['max'];
                                            $features = isset($row['features']) ? $row['features'] : "N/A";

                                            echo "<tr>";
                                            echo "<td>$room_name</td>";
                                            echo "<td>$description</td>";
                                            echo "<td>$price</td>";
                                            echo "<td>$max_tenant</td>";
                                            echo "<td>$features</td>";
                                            echo "<td><a href='#' class='btn btn-primary edit-room' data-toggle='modal' data-target='#editRoomModal' data-room-id='$row[room_id]'>Edit</a> <a href='#' class='btn btn-danger delete-room' data-toggle='modal' data-target='#deleteRoomModal' data-room-id='$row[room_id]'>Delete</a></td>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addroom.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="room_name">Room Name</label>
                            <input type="text" class="form-control" id="room_name" name="room_name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="max_tenant">Max Tenant</label>
                            <input type="number" class="form-control" id="max_tenant" name="max_tenant" required>
                        </div>
                        <div class="form-group">
                            <label for="features">Features</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_airconditioned_add"
                                    name="features[]" value="Air Conditioned">
                                <label class="form-check-label" for="feature_airconditioned_add">Air Conditioned</label>
                            </div>
                            <!-- Wifi -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_wifi_add"
                                    name="features[]" value="Wifi">
                                <label class="form-check-label" for="feature_wifi_add">
                                    Wifi
                                </label>
                            </div>
                            <!-- Own CR -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_restroom_add"
                                    name="features[]" value="Restroom">
                                <label class="form-check-label" for="feature_restroom_add">
                                    Private Restroom
                                </label>
                            </div>
                            <!-- Rice cooker -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_ricecooker_add"
                                    name="features[]" value="Rice Cooker">
                                <label class="form-check-label" for="feature_ricecooker_add">
                                    Rice Cooker
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_washingmachine_add"
                                    name="features[]" value="Washing Machine">
                                <label class="form-check-label" for="feature_washingmachine_add">
                                    Washing Machine
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_tv_add" name="features[]"
                                    value="TV">
                                <label class="form-check-label" for="feature_tv_add">TV</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_fridge_add" name="features[]"
                                    value="Refrigerator">
                                <label class="form-check-label" for="feature_fridge_add">Refrigerator</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_microwave_add" name="features[]"
                                    value="Microwave">
                                <label class="form-check-label" for="feature_microwave_add">Microwave</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_parking_add" name="features[]"
                                    value="Parking">
                                <label class="form-check-label" for="feature_parking_add">Parking</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="feature_cctv_add" name="features[]"
                                    value="Security">
                                <label class="form-check-label" for="feature_cctv_add">CCTV</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="other_features">Other Features</label>
                            <textarea class="form-control" id="other_features_add" name="other_features"></textarea>
                            <!-- Add little note here -->
                            <small class="form-text text-muted">Separate each feature with a comma (,)</small>
                        </div>
                        <div class="form-group">
                            <label for="room_images">Room Images</label>
                            <input type="file" class="form-control-file" id="room_images" name="room_images[]" multiple
                                required>
                        </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Room</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editroom.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="edit-room-id" name="room_id">
                        <div class="form-group">
                            <label for="edit-room_name">Room Name</label>
                            <input type="text" class="form-control" id="edit-room_name" name="room_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea class="form-control" id="edit-description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-price">Price</label>
                            <input type="number" class="form-control" id="edit-price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-max_tenant">Max Tenant</label>
                            <input type="number" class="form-control" id="edit-max_tenant" name="max_tenant" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-features">Features</label>
                            <textarea class="form-control" id="edit-features" name="features" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-room_image">Room Image</label>
                            <input type="file" class="form-control-file" id="edit-room_image" name="room_image">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this room?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#requestlist').DataTable();
            // Handle the click event for the "Edit" button
            $(".edit-room").on("click", function () {
                var roomId = $(this).data("room-id");
                var roomName = $(this).closest("tr").find("td:eq(0)").text();
                var description = $(this).closest("tr").find("td:eq(1)").text();
                var price = $(this).closest("tr").find("td:eq(2)").text();
                var maxTenant = $(this).closest("tr").find("td:eq(3)").text();
                var features = $(this).closest("tr").find("td:eq(4)").text();

                $("#edit-room-id").val(roomId);
                $("#edit-room_name").val(roomName);
                $("#edit-description").val(description);
                $("#edit-price").val(price);
                $("#edit-max_tenant").val(maxTenant);
                $("#edit-features").val(features);

                // Clear the file input for the image (to avoid accidental re-upload)
                $("#edit-room_image").val("");
            });
            // Handle the click event for the "Delete" button
            $(".delete-room").on("click", function () {
                var roomId = $(this).data("room-id");
                console.log(roomId);
                $("#confirmDeleteButton").data("room-id", roomId);

            });

            // Handle the confirmation to delete the room
            $("#confirmDeleteButton").on("click", function () {
                var roomId = $(this).data("room-id");

                // Send an AJAX request to delete the room
                $.ajax({
                    type: "POST",
                    url: "deleteroom.php", // Replace with the actual delete script
                    data: { room_id: roomId },
                    success: function (response) {
                        // Handle the response from the server (e.g., reload the room list)
                        location.reload(); // Reload the page or update the room list in another way
                    }
                });
            });
        });
    </script>

</body>

</html>
