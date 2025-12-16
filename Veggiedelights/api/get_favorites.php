<?php
session_start();
header('Content-Type: application/json');
include '../config.php'; // Adjust path if needed

if(!isset($_SESSION['email'])){
    echo json_encode(['success'=>false,'recipes'=>[]]);
    exit;
}

$email = $_SESSION['email'];

$stmt = $con->prepare("
    SELECT r.id, r.name, r.description, r.image
    FROM recipes r
    JOIN favorites f ON r.id = f.recipe_id
    WHERE f.email = ?
    ORDER BY f.id DESC
");
$stmt->bind_param("s",$email);
$stmt->execute();
$res = $stmt->get_result();

$recipes = [];
while($row = $res->fetch_assoc()){
    $recipes[] = $row;
}

$stmt->close();
echo json_encode(['success'=>true,'recipes'=>$recipes]);
?>
