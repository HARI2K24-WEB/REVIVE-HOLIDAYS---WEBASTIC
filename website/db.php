<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "travel_site";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
