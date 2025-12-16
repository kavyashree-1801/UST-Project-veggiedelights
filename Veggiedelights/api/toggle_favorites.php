<?php
session_start();
include '../config.php';

if(!isset($_SESSION['email'])){
    echo "error";
    exit;
}

$email = $_SESSION['email'];
$recipe_id = $_POST['recipe_id'] ?? '';

if(!$recipe_id){
    echo "error";
    exit;
}

// Check if already favorited
$stmt = $con->prepare("SELECT id FROM favorites WHERE email=? AND recipe_id=?");
$stmt->bind_param("si",$email,$recipe_id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows>0){
    // Already favorite -> remove
    $del = $con->prepare("DELETE FROM favorites WHERE email=? AND recipe_id=?");
    $del->bind_param("si",$email,$recipe_id);
    $del->execute();
    $del->close();
    echo "removed";
}else{
    // Add to favorites
    $ins = $con->prepare("INSERT INTO favorites (email, recipe_id) VALUES (?,?)");
    $ins->bind_param("si",$email,$recipe_id);
    $ins->execute();
    $ins->close();
    echo "added";
}

$stmt->close();
?>
