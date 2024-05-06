<?php
session_start();

// Check if the user is logged in (has an active session)
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: adminlogin.php"); // Replace with the actual login page filename
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
        <nav class="main-header navbar navbar-expand-md navbar-dark navbar-tertiary">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <img src="homefinder.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">Admin Dashboard</span>
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
                            <a href="home_owner.php" class="nav-link">User Management</a>
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
                            <h1 class="m-0"> Owner Management</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <h5 class="text-body">Establishment List</h5><br />
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3 justify-content-center">
                            <table id="requestlist" class="table table-hover table-lg" style="width: 100%;">
                                <thead>
                                    <th>Establishment Name</th>
                                    <th>Address</th>
                                    <th>Photo Files</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM account_establishment";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $address = $row['address'];
                                            $map = $row['map'];
                                            $cover_photo = $row['cover_photo'];
                                            $price = $row['price'];
                                            $type = $row['type'];
                                            $status = $row['status'];
                                            $permit_file = $row['permit_file'];

                                            if ($type == 'boarding_house') {
                                                $type = 'Boarding House';
                                            } else if ($type == 'bedspace') {
                                                $type = 'Bedspace';
                                            } else {
                                                $type = 'Unknown';
                                            }
                                            if ($cover_photo == '') {
                                                $images = '<img src="https://via.placeholder.com/150" class="img-fluid" alt="placeholder">';
                                            } else {
                                                $images = '<a href="#" class="display-file btn btn-primary btn-sm" data-cover-photo="' . $cover_photo . '" data-permit-file="' . $permit_file . '">View Files</a>';
                                            }

                                            if ($status == 'approved') {
                                                $status = '<span class="badge badge-success">Approved</span>';
                                                $actions = '<a class="dropdown-item view-room" href="viewRooms.php?id=' . $id . '">View Rooms</a> <a class="dropdown-item remove-establishment" href="#" data-establishment-id="' . $id . '">Remove</a>';
                                            } else if ($status == 'pending') {
                                                $status = '<span class="badge badge-warning">Pending</span>';
                                                $actions = '<a class="dropdown-item approve-establishment" href="#" data-establishment-id="' . $id . '">Approve</a> <a class="dropdown-item decline-establishment" href="#" data-establishment-id="' . $id . '">Decline</a>';
                                            } else {
                                                $status = '<span class="badge badge-danger">Rejected</span>';
                                                $actions = '<a class="dropdown-item view-room" href="viewRooms.php?id=' . $id . '">View Rooms</a> <a class="dropdown-item remove-establishment" href="#" data-establishment-id="' . $id . '">Remove</a>';
                                            }

                                            echo "<tr>";
                                            echo "<td>$name</td>";
                                            echo "<td>$address</td>";
                                            echo "<td>$images</td>";
                                            echo "<td>$price</td>";
                                            echo "<td>$type</td>";
                                            echo "<td>$status</td>";
                                            echo "<td>";
                                            echo '<div class="btn-group">';
                                            echo '<button type="button" class="btn btn-info  dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                    </button>
                                                    <div class="dropdown-menu" role="menu" style="">';
                                            echo $actions; // Use the computed actions here
                                            echo '</div>';
                                            echo "</div>";

                                            echo "</td>";
                                            echo "</tr>";
                                            

                                        }
                                        ?>
                                        <?php
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

    <div class="modal fade" id="fileDisplayModal" tabindex="-1" role="dialog" aria-labelledby="fileDisplayModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileDisplayModalLabel">Files Display</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h4>Cover Photo</h4><br />
                        <img id="cover-photo" src="" alt="Cover Photo" class="img-fluid">
                    </div>
                    <div class="row">
                        <h4>BIR Permit File</h4><br />
                        <img id="permit-file" src="" alt="Permit File" class="img-fluid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            $('#requestlist').DataTable({
                // Make it responsive
                responsive: true
            });
            // Handle the click event for the "View Files" link
            $(".display-file").on("click", function () {
                var coverPhotoPath = $(this).data("cover-photo");
                var permitFilePath = $(this).data("permit-file");
                $("#cover-photo").attr("src", coverPhotoPath);
                $("#permit-file").attr("src", permitFilePath);
                $("#fileDisplayModal").modal("show");
            });

            $(".approve-establishment").on("click", function () {
                var establishmentId = $(this).data("establishment-id");

                // Send an AJAX request to approveEstablishment.php
                $.ajax({
                    type: "POST",
                    url: "approveEstablishment.php",
                    data: { establishment_id: establishmentId },
                    success: function (response) {
                        // Handle the response from the server (e.g., reload the establishment list)
                        location.reload(); // Reload the page or update the establishment list in another way
                    }
                });
            });

            $(".decline-establishment").on("click", function () {
                var establishmentId = $(this).data("establishment-id");
                console.log(establishmentId);

                // Send an AJAX request to declineEstablishment.php
                $.ajax({
                    type: "POST",
                    url: "declineEstablishment.php",
                    data: { establishment_id: establishmentId },
                    success: function (response) {
                        // Handle the response from the server (e.g., reload the establishment list)
                        location.reload(); // Reload the page or update the establishment list in another way
                    }
                });
            });

            $(".remove-establishment").on("click", function () {
                var establishmentId = $(this).data("establishment-id");
                console.log(establishmentId);

                // Send an AJAX request to declineEstablishment.php
                $.ajax({
                    type: "POST",
                    url: "removeEstablishment.php",
                    data: { establishment_id: establishmentId },
                    success: function (response) {
                        // Handle the response from the server (e.g., reload the establishment list)
                        location.reload(); // Reload the page or update the establishment list in another way
                    }
                });
            });

        });
    </script>

</body>

</html>