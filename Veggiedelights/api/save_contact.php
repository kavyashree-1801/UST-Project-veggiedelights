<?php
session_start();
header('Content-Type: application/json');
include '../config.php'; // Path to your config.php

// Check DB connection
if (!$con || $con->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'Database connection failed: '.$con->connect_error]);
    exit;
}

// Get POST data safely
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['success' => false, 'msg' => 'All fields are required']);
    exit;
}

// Use correct table name: contact_messages
$stmt = $con->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'msg' => 'Query preparation failed: '.$con->error]);
    exit;
}

$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'msg' => 'Your message has been sent successfully!']);
} else {
    echo json_encode(['success' => false, 'msg' => 'Failed to send message: '.$stmt->error]);
}

$stmt->close();
$con->close();
?>
