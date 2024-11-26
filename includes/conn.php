<?php

// declare variables for connecting to database
$servername = "localhost";
$username = "root";
$password = "";
$db = "home_finder1_db";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Server Error". $conn->connect_error);
}