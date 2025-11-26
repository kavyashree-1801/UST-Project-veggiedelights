<?php
include('config.php'); // Make sure this file sets $conn correctly

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $name = isset($_POST['name']) ? mysqli_real_escape_string($con, trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($con, trim($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? mysqli_real_escape_string($con, trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? mysqli_real_escape_string($con, trim($_POST['message'])) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: contact.php?error=empty");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=invalid_email");
        exit;
    }

    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, subject, message, submitted_at)
            VALUES ('$name', '$email', '$subject', '$message', NOW())";

    if (mysqli_query($con, $sql)) {
        header("Location: index.php?success=1");
        exit;
    } else {
        header("Location: contact.php?error=database");
        exit;
    }
} else {
    // If accessed directly without POST
    header("Location: contact.php");
    exit;
}
?>
