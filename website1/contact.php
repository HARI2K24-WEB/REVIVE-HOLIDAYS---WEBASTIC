<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $conn->query("INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')");

    $to = "reviveholidayss.in@gmail.com"; // Replace with your email
    $subject = "New Contact from $name";
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: $email";

    mail($to, $subject, $body, $headers);

    echo "<script>alert('Message sent successfully!'); window.location.href='index.php';</script>";
}
?>
