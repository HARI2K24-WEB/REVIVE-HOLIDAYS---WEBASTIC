<?php
include 'db.php';

$name = $_POST['name'];
$package1 = $_POST['package1'];
$package2 = $_POST['package2'];
$package3 = $_POST['package3'];
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp, "uploads/$image");

$sql = "INSERT INTO places (name, package1, package2, package3, image)
        VALUES ('$name', '$package1', '$package2', '$package3', '$image')";
$conn->query($sql);
header("Location: admin.php");
?>
