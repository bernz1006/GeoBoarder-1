<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Image</title>
</head>
<body>
    <?php
    if (isset($_GET['image'])) {
        $imageURL = $_GET['image'];
        echo "<img src='$imageURL' style='max-width: 100%; max-height: 100vh;'>";
    } else {
        echo "Image not found.";
    }
    ?>
</body>
</html>
