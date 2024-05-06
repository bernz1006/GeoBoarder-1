<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo Boarder</title>
    <!-- Include your CSS and JavaScript files here -->
    <style>
        .carousel-item {
            height: 65vh;
            min-height: 350px;
            background: no-repeat center center scroll;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .carousel-caption {
            font-size: 1.5rem;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-family: 'Roboto', sans-serif;
            text-shadow: 2px 2px 4px #000000;
            bottom: 220px;
            /* Change the color */
        }

        .slider-range {
            width: 100%;

        }
    </style>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url('images/Apartment1.jpg')">
                    <div class="carousel-caption">
                        <h5>Welcome to GEO-BOARDER</h5>
                        <p>Are you a student seeking a cozy room near your university?</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('images/Apartment2.jpg')">
                    <div class="carousel-caption">
                        <h5>Find the Perfect Space</h5>
                        <p>Perhaps you’re a part-time worker looking for a convenient boarding house close to your workplace.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('images/Apartment3.jpg')">
                    <div class="carousel-caption">
                        <h5>Your Student Living Experience</h5>
                        <p>Or maybe you’re a visitor exploring Cabanatuan City and need a comfortable place to stay. Look no further—Geo-Boarder has got you covered!</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <section class="content">
            <div class="container-fluid">
                <h2 class="text-center display-4">Search For Shelter</h2>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form>
                            <div class="input-group">
                                <input type="search" class="form-control form-control-lg searchbar"
                                    placeholder="Enter keywords here">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2 offset-md-2 mr-3">
                        <h4>Price Range (PHP)</h4>
                        <div class="row">
                            <div class="input-group">
                                <div class="slider-range"></div>
                            </div>
                            <div class="input-group mt-2">
                                <input type text" class="form-control form-control max" id="maxPrice">
                            </div>
                        </div>
                    </div>

                    <!-- Add the checkboxes for apartment type selection -->
                    <div class="col-md-3">
                        <h4>Shelters Type</h4>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apartmentTypes[]"
                                id="boardingType" value="apartment">
                            <label class="form-check-label" for="boardingType">
                                Boarding House
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apartmentTypes[]"
                                id="bedspaceType" value="transient">
                            <label class="form-check-label" for="bedspaceType">
                                Bedspace
                            </label>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row mt-2 border-0">
                    <?php
                    // Include your database connection file here
                    include_once 'conn.php';

                    // Fetch establishment data
                    $sql = "SELECT * FROM account_establishment WHERE status = 'approved'";
                    $result = mysqli_query($conn, $sql);

                    // Loop through each establishment
                    while ($row = mysqli_fetch_array($result)) {
                        // Extract establishment data
                        $image = $row['cover_photo'];
                        $price = $row['price'];
                        $name = $row['name'];
                        $address = $row['address'];
                        $type = $row['type'];
                        $type_option = $row['type_option'];
                        $near = $row['near'];
                        $id = $row['id']; // Set $id to the establishment ID

                        // Ratings query
                        $sql_ratings = "SELECT * FROM ratings WHERE establishment_id = '$id'";
                        $result_ratings = mysqli_query($conn, $sql_ratings);

                        // Calculate average rating
                        if ($result_ratings) {
                            $count_ratings = mysqli_num_rows($result_ratings);
                            $total_ratings = 0;
                            if ($count_ratings > 0) {
                                while ($row_ratings = mysqli_fetch_array($result_ratings)) {
                                    $ratings = $row_ratings['ratings'];
                                    $total_ratings += $ratings;
                                }
                                $average_rating = $total_ratings / $count_ratings;
                                $average_rating_badge = '<span class="badge badge-warning"><i class="fa fa-star"></i> ' . $average_rating . ' / 5</span>';
                            } else {
                                $average_rating_badge = '<span class="badge badge-secondary"><i class="fa fa-star"></i> No Ratings yet</span>';
                            }
                        } else {
                            $average_rating_badge = '<span class="badge badge-secondary"><i class="fa fa-star"></i> Error fetching ratings</span>';
                        }
                    ?>
                        <!-- Output HTML for establishment -->
                        <div class="col-md-3 mb-4 apartment" style="min-height: 300px;">
                            <div class="card apartment">
                                <img class="card-img-top" src="<?php echo $image; ?>" alt="<?php echo $name; ?>"
                                    style="height: 200px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $name; ?></h5>
                                    <p class="card-text">Price: <?php echo $price; ?></p>
                                    <p class="card-text">Address: <?php echo $address; ?></p>
                                    <p class="card-text">Near Universities: <?php echo $near; ?></p>
                                    <p class="card-text">Type: <?php echo $type; ?></p>
                                    <p class="card-text">Type Option: <?php echo $type_option; ?></p>
                                    <div class="ratings"><?php echo $average_rating_badge; ?></div>
                                </div>
                                <div class="card-footer">
                                    <a href="viewRooms.php?id=<?php echo $id; ?>" class="btn btn-block btn-success">View
                                        Apartment</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- Add this modal structure at the end of your HTML body -->
    <div class="modal fade" id="apartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apartment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display apartment details, room list, availability, and owner's name here -->
                    <div id="apartmentDetails"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add modal for user name  -->


</div>
</body>
</html>
