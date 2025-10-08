<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../db.php';

// ADD NEW PACKAGE
if (isset($_POST['add_package'])) {
    $place_name = $conn->real_escape_string($_POST['place_name']);
    $package_name = $conn->real_escape_string($_POST['package_name']);
    $day1 = $conn->real_escape_string($_POST['day1']);
    $day2 = $conn->real_escape_string($_POST['day2']);
    $day3 = $conn->real_escape_string($_POST['day3']);

    // Handle image upload
    $target_dir = "../uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO packages (place_name, package_name, day1, day2, day3, image)
                      VALUES ('$place_name', '$package_name', '$day1', '$day2', '$day3', '$image_name')");
        echo "<script>alert('Package added successfully!'); window.location.href='packages.php';</script>";
    } else {
        echo "<script>alert('Image upload failed.');</script>";
    }
}

// DELETE PACKAGE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Delete image file
    $imgRes = $conn->query("SELECT image FROM packages WHERE id=$id");
    $img = $imgRes->fetch_assoc()['image'];
    if (file_exists("../uploads/$img")) unlink("../uploads/$img");

    // Delete from DB
    $conn->query("DELETE FROM packages WHERE id=$id");
    echo "<script>alert('Package deleted successfully!'); window.location.href='packages.php';</script>";
}

// UPDATE PACKAGE
if (isset($_POST['update_package'])) {
    $id = (int)$_POST['id'];
    $place_name = $conn->real_escape_string($_POST['place_name']);
    $package_name = $conn->real_escape_string($_POST['package_name']);
    $day1 = $conn->real_escape_string($_POST['day1']);
    $day2 = $conn->real_escape_string($_POST['day2']);
    $day3 = $conn->real_escape_string($_POST['day3']);

    $update_query = "UPDATE packages SET place_name='$place_name', package_name='$package_name', day1='$day1', day2='$day2', day3='$day3'";

    // Optional image update
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $update_query .= ", image='$image_name'";
        }
    }

    $update_query .= " WHERE id=$id";
    $conn->query($update_query);

    echo "<script>alert('Package updated successfully!'); window.location.href='packages.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Manage Packages</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      padding: 20px;
    }
    h2 {
      color: #222;
      text-align: center;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      max-width: 600px;
      margin: 20px auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input, textarea, select, button {
      width: 100%;
      margin: 8px 0;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      background: #ff9500;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    button:hover { background: #ff7f00; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }
    th {
      background: #ff9500;
      color: white;
    }
    td img {
      width: 100px;
      border-radius: 6px;
    }
    a.btn {
      padding: 6px 10px;
      text-decoration: none;
      border-radius: 5px;
      color: white;
    }
    .btn-edit { background: #007bff; }
    .btn-delete { background: #dc3545; }
  </style>
</head>
<body>

<h2>Manage Packages</h2>

<!-- ADD/EDIT FORM -->
<?php
$edit = false;
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit = true;
    $id = (int)$_GET['edit'];
    $edit_data = $conn->query("SELECT * FROM packages WHERE id=$id")->fetch_assoc();
}
?>

<form action="packages.php" method="POST" enctype="multipart/form-data">
  <?php if ($edit): ?>
    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
  <?php endif; ?>
  
  <input type="text" name="place_name" placeholder="Place Name" value="<?= $edit ? $edit_data['place_name'] : '' ?>" required>
  <input type="text" name="package_name" placeholder="Package Name" value="<?= $edit ? $edit_data['package_name'] : '' ?>" required>
  <textarea name="day1" placeholder="Day 1 Plan" required><?= $edit ? $edit_data['day1'] : '' ?></textarea>
  <textarea name="day2" placeholder="Day 2 Plan"><?= $edit ? $edit_data['day2'] : '' ?></textarea>
  <textarea name="day3" placeholder="Day 3 Plan"><?= $edit ? $edit_data['day3'] : '' ?></textarea>
  <input type="file" name="image" accept="image/*" <?= $edit ? '' : 'required' ?>>
  
  <button type="submit" name="<?= $edit ? 'update_package' : 'add_package' ?>">
    <?= $edit ? 'Update Package' : 'Add Package' ?>
  </button>
</form>

<!-- PACKAGE TABLE -->
<table>
  <tr>
    <th>ID</th>
    <th>Image</th>
    <th>Place</th>
    <th>Package</th>
    <th>Day 1</th>
    <th>Day 2</th>
    <th>Day 3</th>
    <th>Action</th>
  </tr>

  <?php
  $result = $conn->query("SELECT * FROM packages ORDER BY created_at DESC");
  while ($row = $result->fetch_assoc()):
  ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt=""></td>
      <td><?= htmlspecialchars($row['place_name']) ?></td>
      <td><?= htmlspecialchars($row['package_name']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['day1'])) ?></td>
      <td><?= nl2br(htmlspecialchars($row['day2'])) ?></td>
      <td><?= nl2br(htmlspecialchars($row['day3'])) ?></td>
      <td>
        <a href="packages.php?edit=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
        <a href="packages.php?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this package?');">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
