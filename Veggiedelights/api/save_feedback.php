<?php
session_start();
include '../config.php';  // Adjust path if necessary
header('Content-Type: application/json');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$rating = $_POST['rating'] ?? '';
$message = $_POST['message'] ?? '';

if(!$name || !$email || !$rating || !$message){
    echo json_encode(['success'=>false,'msg'=>'All fields are required']);
    exit;
}

$stmt = $con->prepare("INSERT INTO feedback (name, email, rating, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $name, $email, $rating, $message);

if($stmt->execute()){
    echo json_encode(['success'=>true,'msg'=>'✅ Thank you for your feedback!']);
}else{
    echo json_encode(['success'=>false,'msg'=>'⚠ Failed to submit feedback']);
}
$stmt->close();
