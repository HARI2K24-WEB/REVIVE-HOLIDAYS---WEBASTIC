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
