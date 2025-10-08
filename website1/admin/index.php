<?php
include '../db.php'; 
ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 900); // optional: 15 min
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
// Session timeout: 15 minutes
$timeout_duration = 900; // 900 seconds = 15 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // Session expired
    session_unset();
    session_destroy();
    header("Location: admin_login.php?timeout=1");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time

?>
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
