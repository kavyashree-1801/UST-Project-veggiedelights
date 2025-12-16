<?php
session_start();
include "../config.php";

header("Content-Type: application/json");

// ================= CAPTCHA CHECK =================
if (!isset($_POST['captcha']) || $_POST['captcha'] != $_SESSION['login_captcha_answer']) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid CAPTCHA!"
    ]);
    exit;
}

// ================= INPUT VALIDATION =================
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($email === '' || $password === '') {
    echo json_encode([
        "success" => false,
        "error" => "All fields are required!"
    ]);
    exit;
}

// ================= FETCH USER =================
$stmt = $con->prepare("SELECT id, email, password, role FROM signup WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid email or password!"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// ================= PASSWORD VERIFY =================
if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid email or password!"
    ]);
    exit;
}

// ================= LOGIN SUCCESS =================
$_SESSION['email'] = $user['email'];
$_SESSION['role']  = $user['role'];
$_SESSION['user_id'] = $user['id'];

// ================= REDIRECT BASED ON ROLE =================
if ($user['role'] === 'admin') {
    echo json_encode([
        "success" => true,
        "role" => "admin",
        "redirect" => "index.php"
    ]);
} else {
    echo json_encode([
        "success" => true,
        "role" => "user",
        "redirect" => "index.php"
    ]);
}
