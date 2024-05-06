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
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request List</title>

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
                <a href="index.php" class="navbar-brand">
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
                        <li class="navbar-nav">
                            <a href="tenantlist.php" class="nav-link">Tenant List</a>
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
                            <h1 class="m-0"> Request List</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <h5 class="text-body">Tenant Request</h5><br />
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="requestlist" class="table table-hover">
                                <thead>
                                    <th>Room Name</th>
                                    <th>Full Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Selfie Picture</th>
                                    <th>Valid ID</th>
                                    <th>Proof of Payment</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT room_id FROM rooms WHERE establishment_id = $id";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $room_id = $row['room_id'];

                                            $sql = "SELECT * from reservations where room_id = $room_id and status = 'pending'";
                                            $result2 = mysqli_query($conn, $sql);

                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                $user_id = $row2["id"];
                                                $name = $row2["name"];
                                                $contact = $row2["contact"];
                                                $email = $row2["email"];
                                                $address = $row2["address"];
                                                $selfie_file = isset($row2["selfie_file"]) ? $row2["selfie_file"] : ''; // Handle undefined array key
                                                $reservation_date = $row2["reservation_date"];
                                                $valid_id_file = isset($row2["valid_id_file"]) ? $row2["valid_id_file"] : ''; // Handle undefined array key
                                                $proof_of_payment_file = isset($row2["proof_of_payment_file"]) ? $row2["proof_of_payment_file"] : ''; // Handle undefined array key
                                                $status = $row2["status"];
                                                $room_id = $row2["room_id"];

                                                $sql2 = "SELECT * from rooms where room_id = $room_id";
                                                $result3 = mysqli_query($conn, $sql2);
                                                $row3 = mysqli_fetch_assoc($result3);
                                                $room_name = $row3["room_name"];

                                                echo "<tr>";
                                                echo "<td>$room_name</td>";
                                                echo "<td>$name</td>";
                                                echo "<td>$contact</td>";
                                                echo "<td>$email</td>";
                                                echo "<td>$address</td>";
                                                echo "<td><a href='view_image.php?image=$selfie_file' target='_blank'>View</a></td>";
                                                echo "<td><a href='view_image.php?image=$valid_id_file' target='_blank'>View</a></td>";
                                                echo "<td><a href='view_image.php?image=$proof_of_payment_file' target='_blank'>View</a></td>";
                                                echo "<td><a href='#' class='btn btn-success approve-room' data-toggle='modal' data-target='#approveRoomModal' data-room-id='$user_id'>Approve</a> <a href='#' class='btn btn-warning decline-room' data-toggle='modal' data-target='#declineRoomModal' data-room-id='$user_id'>Decline</a></td>";
                                                echo "</tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No requests found.</td></tr>";
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
    <!-- Approval Confirmation Modal -->
    <div class="modal fade" id="approveRoomModal" tabindex="-1" role="dialog" aria-labelledby="approveRoomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveRoomModalLabel">Confirm Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to approve this request?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmApproveButton">Approve</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Decline Confirmation Modal -->
    <div class="modal fade" id="declineRoomModal" tabindex="-1" role="dialog" aria-labelledby="declineRoomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineRoomModalLabel">Confirm Decline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to decline this request?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="confirmDeclineButton">Decline</button>
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
            // Handle the click event for the "Approve" button
            $(".approve-room").on("click", function () {
                var roomId = $(this).data("room-id");
                console.log(roomId);
                $("#confirmApproveButton").data("room-id", roomId);
            });

            // Handle the confirmation to approve the room
            $("#confirmApproveButton").on("click", function () {
                var roomId = $(this).data("room-id");
                console.log(roomId);

                // Send an AJAX request to update the room's status
                $.ajax({
                    type: "POST",
                    url: "approve.php", // Replace with the actual approve script
                    data: { room_id: roomId },
                    success: function (response) {
                        location.reload();
                    }
                });
            });
            // Handle the click event for the "Decline" button
            $(".decline-room").on("click", function () {
                var roomId = $(this).data("room-id");
                $("#confirmDeclineButton").data("room-id", roomId);
            });

            // Handle the confirmation to decline the room
            $("#confirmDeclineButton").on("click", function () {
                var roomId = $(this).data("room-id");

                // Send an AJAX request to update the room's status
                $.ajax({
                    type: "POST",
                    url: "decline.php", // Replace with the actual decline script
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
