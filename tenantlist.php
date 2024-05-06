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
        /* Add background image */
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
                    <img src="homefinder.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
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
                        <h5 class="text-body">Tenant List</h5><br />
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="requestlist" class="table table-hover">
                                <thead>
                                    <th>Room Name</th>
                                    <th>FullName</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Selfie Picture</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch room data first
                                    $sql = "SELECT room_id FROM rooms WHERE establishment_id = $id";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $room_id = $row['room_id'];

                                            $sql = "SELECT * from reservations where room_id = $room_id and status = 'approved'";
                                            $result2 = mysqli_query($conn, $sql);

                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                $name = $row2["name"];
                                                $contact = $row2["contact"];
                                                $email = $row2["email"];
                                                $address = $row2["address"];
                                                $selfie_file = $row2["selfie_file"];
                                                $reservation_date = $row2["reservation_date"];
                                                $valid_id_file = $row2["valid_id_file"];
                                                $room_id = $row2["room_id"];
                                                $id = $row2["id"];

                                                $sql = "SELECT * from rooms where room_id = $room_id";
                                                $result3 = mysqli_query($conn, $sql);
                                                $row3 = mysqli_fetch_assoc($result3);
                                                $room_name = $row3["room_name"];

                                                echo "<tr>";
                                                echo "<td>$room_name</td>";
                                                echo "<td>$name</td>";
                                                echo "<td>$contact</td>";
                                                echo "<td>$email</td>";
                                                echo "<td>$address</td>";
                                                echo "<td><img src='$selfie_file' width='100' height='100'></td>";
                                                echo "<td><a href='#' class='btn btn-primary view-tenant' data-toggle='modal' data-target='#viewTenantModal' data-tenant-details='" . htmlspecialchars(json_encode($row2), ENT_QUOTES, 'UTF-8') . "'>View</a> <a href='#' class='btn btn-danger remove-tenant' data-toggle='modal' data-target='#removeTenantModal' data-tenant-id='$id'>Remove Tenant</a></td>";
                                                echo "</tr>";
                                            }
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
    <div class="modal fade" id="viewTenantModal" tabindex="-1" role="dialog" aria-labelledby="viewTenantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTenantModalLabel">Tenant Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display tenant details here -->
                    <div id="tenantDetails">
                        <p><strong>Name:</strong> <span id="tenantName"></span></p>
                        <p><strong>Contact:</strong> <span id="tenantContact"></span></p>
                        <p><strong>Email:</strong> <span id="tenantEmail"></span></p>
                        <p><strong>Address:</strong> <span id="tenantAddress"></span></p>
                        <p><strong>Reservation Date:</strong> <span id="reservationDate"></span></p>
                        <p><strong>Status:</strong> <span id="tenantStatus"></span></p>
                        <p><strong>Selfie Picture:</strong></p>
                        <img id="selfieImage" src="" alt="Selfie Picture" style="max-width: 100%; max-height: 200px;">
                        <p><strong>Valid ID Picture:</strong></p>
                        <img id="validIdImage" src="" alt="Valid ID Picture"
                            style="max-width: 100%; max-height: 200px;">
                        <p><strong>Proof of Payment Picture:</strong></p>
                        <img id="proofOfPaymentImage" src="" alt="Proof of Payment Picture"
                            style="max-width: 100%; max-height: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="removeTenantModal" tabindex="-1" role="dialog" aria-labelledby="removeTenantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeTenantModalLabel">Remove Tenant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this tenant?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmRemoveTenantButton">Remove Tenant</button>
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

            // Function to format a date in a more user-friendly way
            function formatReservationDate(reservationDate) {
                const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                return new Date(reservationDate).toLocaleDateString(undefined, options);
            }

            // Handle the click event for the "View" button
            $(".view-tenant").on("click", function () {
                var tenantDetails = $(this).data("tenant-details");

                // Format the reservation date and populate the modal with tenant details
                $("#tenantName").text(tenantDetails.name);
                $("#tenantContact").text(tenantDetails.contact);
                $("#tenantEmail").text(tenantDetails.email);
                $("#tenantAddress").text(tenantDetails.address);
                $("#reservationDate").text(formatReservationDate(tenantDetails.reservation_date));
                $("#tenantStatus").text(tenantDetails.status);
                $("#selfieImage").attr("src", tenantDetails.selfie_file);
                $("#validIdImage").attr("src", tenantDetails.valid_id_file);
                $("#proofOfPaymentImage").attr("src", tenantDetails.proof_of_payment_file);
            });
            // Handle the click event for the "Remove Tenant" button
            $(".remove-tenant").on("click", function () {
                var tenantId = $(this).data("tenant-id");
                $("#confirmRemoveTenantButton").data("tenant-id", tenantId);
            });

            // Handle the confirmation to remove the tenant
            $("#confirmRemoveTenantButton").on("click", function () {
                var tenantId = $(this).data("tenant-id");

                // Send an AJAX request to remove the tenant
                $.ajax({
                    type: "POST",
                    url: "remove_tenant.php", // Replace with the actual removal script
                    data: { tenant_id: tenantId },
                    success: function (response) {
                        // Handle the response from the server (e.g., reload the tenant list)
                        location.reload(); // Reload the page or update the tenant list in another way
                    }
                });
            });
        });
    </script>

</body>

</html>