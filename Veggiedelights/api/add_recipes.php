<?php
session_start();
include '../config.php'; // adjust path if needed
header('Content-Type: application/json');

$email = $_SESSION['email'] ?? '';
if(!$email){
    echo json_encode(['success'=>false,'msg'=>'You must be logged in']);
    exit;
}

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$ingredients = $_POST['ingredients'] ?? '';
$steps = $_POST['steps'] ?? '';
$image = $_POST['image'] ?? '';
$category = $_POST['category'] ?? '';

if(!$name || !$description || !$ingredients || !$steps || !$image || !$category){
    echo json_encode(['success'=>false,'msg'=>'All fields are required']);
    exit;
}

$stmt = $con->prepare("INSERT INTO recipes (name, description, ingredients, steps, image, category, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $description, $ingredients, $steps, $image, $category, $email);

if($stmt->execute()){
    echo json_encode(['success'=>true,'msg'=>'✅ Recipe added successfully!']);
} else {
    echo json_encode(['success'=>false,'msg'=>'⚠ Failed to add recipe']);
}
$stmt->close();
