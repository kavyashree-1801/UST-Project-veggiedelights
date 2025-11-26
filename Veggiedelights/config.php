<?php
// Database connection settings
$server = "localhost";  // Your database host (localhost or remote)
$user = "root";         // Your database username
$password = "";         // Your database password (leave empty for local setup)
$db = "veggiedelights";    // Your database name

// Create connection
$con = new mysqli($server, $user, $password, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>