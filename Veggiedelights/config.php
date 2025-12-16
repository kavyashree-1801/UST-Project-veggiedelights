<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db   = "veggiedelights";

// Create connection
$con = new mysqli($host, $user, $pass, $db);

// Check connection
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

// Set UTF-8 charset
$con->set_charset("utf8mb4");
?>
