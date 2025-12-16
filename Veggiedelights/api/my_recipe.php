<?php
session_start();
include '../config.php'; // adjust path if needed

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$email = $_SESSION['email'];

// Fetch all fields including ingredients and steps
$stmt = $con->prepare("SELECT id, name, description, image, ingredients, steps FROM recipes WHERE email=? ORDER BY id DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'image' => !empty($row['image']) ? $row['image'] : 'images/default.png',
        'ingredients' => $row['ingredients'], // fetch ingredients
        'steps' => $row['steps']              // fetch steps
    ];
}

echo json_encode(['success' => true, 'recipes' => $recipes]);
exit;
