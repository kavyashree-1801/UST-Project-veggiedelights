<?php
session_start();
include 'config.php'; // Make sure $con is your mysqli connection

if (!isset($_SESSION['email'])) {
    http_response_code(403);
    echo 'Login required';
    exit;
}

$email = $_SESSION['email'];
$recipe_id = $_POST['recipe_id'] ?? '';

if (!$recipe_id || !is_numeric($recipe_id)) {
    http_response_code(400);
    echo 'Invalid recipe ID';
    exit;
}

// 1️⃣ Check if recipe is already favorited
$stmt = $con->prepare("SELECT * FROM favorites WHERE email=? AND recipe_id=?");
if (!$stmt) {
    die("Prepare failed: ".$con->error); // <-- Shows exact SQL error
}
$stmt->bind_param("si", $email, $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Remove from favorites
    $stmt2 = $con->prepare("DELETE FROM favorites WHERE email=? AND recipe_id=?");
    if (!$stmt2) { die("Prepare failed: ".$con->error); }
    $stmt2->bind_param("si", $email, $recipe_id);
    $stmt2->execute();
    echo 'removed';
    $stmt2->close();
} else {
    // Add to favorites
    $stmt2 = $con->prepare("INSERT INTO favorites (email, recipe_id) VALUES (?, ?)");
    if (!$stmt2) { die("Prepare failed: ".$con->error); }
    $stmt2->bind_param("si", $email, $recipe_id);
    $stmt2->execute();
    echo 'added';
    $stmt2->close();
}

$stmt->close();
?>
