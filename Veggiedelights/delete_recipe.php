<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

if(!isset($_SESSION['email'])){
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$email = $_SESSION['email'];

$id = intval($_POST['id'] ?? 0);
if($id <= 0){
    echo json_encode(["success" => false, "error" => "Invalid recipe ID"]);
    exit;
}

// Delete recipe only if it belongs to logged-in user
$stmt = $con->prepare("DELETE FROM recipes WHERE id=? AND email=?");
$stmt->bind_param("is", $id, $email);
if($stmt->execute()){
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Could not delete recipe"]);
}
?>
