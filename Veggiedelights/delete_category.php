<?php
include 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$id = intval($_GET['id']);
mysqli_query($con, "DELETE FROM categories WHERE id = $id");
header("Location: manage_categories.php");
exit();
?>
