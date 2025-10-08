<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <h1>Admin Dashboard</h1>
  <nav>
    <a href="packages.php" style="color:white;">Manage Packages</a> |
    <a href="contacts.php" style="color:white;">View Contacts</a>
    <a href="logout.php" style="float:right; color:red;">Logout</a>

  </nav>
</body>
</html>
