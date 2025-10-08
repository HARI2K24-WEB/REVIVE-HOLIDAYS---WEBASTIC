<?php
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

<?php
include '../db.php';
if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $conn->query("DELETE FROM contact_messages WHERE id=$id");
}
header("Location: contacts.php");
exit;
?>
