<?php
session_start();
include 'config.php';

header("Content-Type: application/json");

$response = ["success" => false, "error" => ""];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['error'] = "Invalid request";
    echo json_encode($response);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';
$question = $_POST['security_question'] ?? '';
$answer = trim($_POST['security_answer'] ?? '');
$captcha = $_POST['captcha'] ?? '';

if ($password !== $confirm) {
    $response['error'] = "Passwords do not match";
    echo json_encode($response);
    exit;
}

if (!isset($_SESSION['captcha_answer']) || $captcha != $_SESSION['captcha_answer']) {
    $response['error'] = "Wrong CAPTCHA";
    echo json_encode($response);
    exit;
}

$stmt = $con->prepare("SELECT id FROM signup WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $response['error'] = "Email already exists";
    echo json_encode($response);
    exit;
}
$stmt->close();

$profile = "";
if (!empty($_FILES['profile_pic']['name'])) {
    $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png'])) {
        $response['error'] = "Only JPG, PNG allowed";
        echo json_encode($response);
        exit;
    }
    if (!is_dir("uploads")) mkdir("uploads");
    $profile = "IMG_" . time() . "." . $ext;
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/" . $profile);
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$role = "user";

$stmt = $con->prepare(
    "INSERT INTO signup 
    (name,email,password,security_question,security_answer,role,profile_pic)
    VALUES (?,?,?,?,?,?,?)"
);

$stmt->bind_param("sssssss",
    $name,$email,$hash,$question,$answer,$role,$profile
);

$stmt->execute();

$response['success'] = true;
unset($_SESSION['captcha_answer']);
echo json_encode($response);
