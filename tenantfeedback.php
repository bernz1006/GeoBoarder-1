<?php
include_once 'includes/conn.php';
include_once 'send-email.php';

$id = $_GET['id'];
$establishment_id = $_GET['establishment_id'];

if (isset($_POST['submit'])) {
    $tenantfeedback = $_POST['tenantfeedback'];
    $tenantrating = $_POST['tenantrating'];

    $sql = "INSERT INTO ratings (feedback, ratings, reservation_id, establishment_id) VALUES ('$tenantfeedback', '$tenantrating', '$id', '$establishment_id')";
    mysqli_query($conn, $sql);
    
    $sql = "SELECT * FROM account_establishment WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $establishment = mysqli_fetch_assoc($result);

    // Get the owner's details
    $ownerId = $establishment["owner_id"];

    // Send an email to the owner
    $to = $owner["email"];
    $subject = "Tenant Feedback";
    $type = "Tenant Feedback";
    $message = "Your tenant has given feedback. Please check your dashboard for more details.";
    $topic = "Tenant Feedback";
    $datetime = date("Y-m-d H:i:s");
    $sender = "Home Finder Team";

    sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);
    
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Site</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Tenant Feedback</h1>
                <div class="card mx-auto mt-5" style="width: 400px;">
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="tenantfeedback">Tenant Feedback</label>
                                <textarea class="form-control" name="tenantfeedback" id="tenantfeedback" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tenantrating">Tenant Rating</label>
                                <select class="form-control" name="tenantrating" id="tenantrating">
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="index.php" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>