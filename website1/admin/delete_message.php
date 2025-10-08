<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../db.php';
if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $conn->query("DELETE FROM contact_messages WHERE id=$id");
}
header("Location: contacts.php");
exit;
?>
