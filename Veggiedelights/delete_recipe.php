<?php
session_start();
include 'config.php';

// Redirect if not logged in
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

// Validate recipe ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid recipe request.");
}

$recipe_id = intval($_GET['id']);

// ✅ Check if recipe belongs to the logged-in user
$stmt = $con->prepare("SELECT page_name FROM myrecipe WHERE id = ? AND email = ?");
$stmt->bind_param("is", $recipe_id, $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    die("❌ Unauthorized action or recipe not found.");
}

$row = $result->fetch_assoc();
$page_file = $row['page_name'];

// ✅ Delete recipe from DB
$delete = $con->prepare("DELETE FROM myrecipe WHERE id = ? AND email = ?");
$delete->bind_param("is", $recipe_id, $email);

if($delete->execute()) {

    // ✅ Delete generated recipe file if exists
    if(!empty($page_file) && file_exists($page_file)){
        unlink($page_file);
    }

    // ✅ Redirect back
    header("Location: my_recipes.php?msg=deleted");
    exit;

} else {
    echo "⚠ Something went wrong!";
}
?>
