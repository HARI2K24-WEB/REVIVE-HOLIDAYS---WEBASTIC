<?php
// --- Session Configuration ---
ini_set('session.cookie_lifetime', 0);      // Session expires when browser closes
ini_set('session.gc_maxlifetime', 900);     // Max session lifetime = 15 min
session_start();

// --- Session Timeout (15 minutes) ---
$timeout_duration = 900;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // Session expired
    session_unset();
    session_destroy();
    header("Location: admin_login.php?timeout=1");
    exit();
}

// If admin already logged in and visits login page, redirect directly to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// --- Database Connection ---
include '../db.php';

// --- Login Handler ---
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admin_users WHERE username='$username'");

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password hash
        if (password_verify($password, $user['password_hash'])) {
            // ✅ Create a fresh session
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['admin'] = $user['username'];
            $_SESSION['LAST_ACTIVITY'] = time(); // Start tracking activity

            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No such user found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body {
      background: linear-gradient(135deg, #ffa600, #ff6200);
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    form {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      width: 300px;
    }
    h2 {
      text-align: center;
      color: #ff6200;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #ff6200;
      border: none;
      color: #fff;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #e65c00;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <form method="POST" action="">
    <h2>Admin Login</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
  </form>
</body>
</html>
