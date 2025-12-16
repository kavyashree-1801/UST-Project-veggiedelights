<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

// Check if user is logged in
if(!isset($_SESSION['email'])){
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$email = $_SESSION['email'];

// Fetch user recipes
$stmt = $con->prepare("SELECT id, name, image, description FROM recipes WHERE email=? ORDER BY id DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while($row = $result->fetch_assoc()){
    $recipes[] = $row;
}

echo json_encode(["success" => true, "recipes" => $recipes]);
?>
