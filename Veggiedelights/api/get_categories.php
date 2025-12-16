<?php
header("Content-Type: application/json");
session_start();

// Database connection
$server = "localhost";
$user = "root";
$password = "";
$db = "veggiedelights";

$con = new mysqli($server, $user, $password, $db);
if ($con->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Fetch categories
$sql = "SELECT name, image FROM categories ORDER BY id DESC";
$result = $con->query($sql);

$categories = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $categories[] = [
            "name" => $row['name'],
            "image" => $row['image'] // Should be full URL or relative path
        ];
    }
}

echo json_encode(["success" => true, "categories" => $categories]);
?>
