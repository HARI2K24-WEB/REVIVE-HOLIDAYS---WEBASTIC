<?php
ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 900); // optional: 15 min
session_start();
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
  <title>Admin - Contacts</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <h2>Contact Messages</h2>
  <table border="1" cellpadding="10">
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th>Action</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    while($row = $result->fetch_assoc()) {
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['message']}</td>
        <td>{$row['created_at']}</td>
        <td><a href='delete_message.php?id={$row['id']}'>Delete</a></td>
      </tr>";
    }
    ?>
  </table>
</body>
</html>
