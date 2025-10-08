<?php
include 'db.php';
$id = $_GET['id'];
$res = $conn->query("SELECT * FROM places WHERE id=$id");
$row = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $p1 = $_POST['package1'];
  $p2 = $_POST['package2'];
  $p3 = $_POST['package3'];

  if ($_FILES['image']['name']) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    $conn->query("UPDATE places SET name='$name', package1='$p1', package2='$p2', package3='$p3', image='$image' WHERE id=$id");
  } else {
    $conn->query("UPDATE places SET name='$name', package1='$p1', package2='$p2', package3='$p3' WHERE id=$id");
  }

  header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Place</title>
</head>
<body style="background:#111; color:#fff; padding:20px;">
  <h2>Edit Package</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= $row['name'] ?>"><br>
    <textarea name="package1"><?= $row['package1'] ?></textarea><br>
    <textarea name="package2"><?= $row['package2'] ?></textarea><br>
    <textarea name="package3"><?= $row['package3'] ?></textarea><br>
    <img src="uploads/<?= $row['image'] ?>" width="120"><br>
    <input type="file" name="image"><br><br>
    <button type="submit">Update</button>
  </form>
</body>
</html>
