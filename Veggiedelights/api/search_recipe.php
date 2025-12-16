<?php
header('Content-Type: application/json');
include '../config.php';

$q = $_GET['q'] ?? '';
$q = "%$q%";

$stmt = $con->prepare("SELECT id, name, description, ingredients, steps, image FROM recipes WHERE name LIKE ? ORDER BY id DESC");
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while($row = $result->fetch_assoc()){
    $recipes[] = $row;
}

echo json_encode([
    'success' => true,
    'recipes' => $recipes
]);
?>
