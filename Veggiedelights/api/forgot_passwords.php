<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
include "../config.php"; // adjust path if needed

if (!isset($_POST['step'])) {
    echo json_encode(["success"=>false,"error"=>"Invalid request"]);
    exit;
}

$step = $_POST['step'];

/* STEP 1: Get security question */
if ($step == "1") {
    $email = trim($_POST['email'] ?? '');
    if ($email == '') {
        echo json_encode(["success"=>false,"error"=>"Email required"]);
        exit;
    }

    $stmt = $con->prepare("SELECT security_question FROM signup WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo json_encode(["success"=>false,"error"=>"Email not found"]);
        exit;
    }

    $row = $res->fetch_assoc();
    echo json_encode(["success"=>true,"question"=>$row['security_question']]);
    exit;
}

/* STEP 2: Verify answer and reset password */
if ($step == "2") {
    $email = trim($_POST['email'] ?? '');
    $answer = trim($_POST['answer'] ?? '');
    $newPassword = trim($_POST['newPassword'] ?? '');

    if ($email == '' || $answer == '' || $newPassword == '') {
        echo json_encode(["success"=>false,"error"=>"All fields required"]);
        exit;
    }

    $stmt = $con->prepare("SELECT security_answer FROM signup WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo json_encode(["success"=>false,"error"=>"Invalid request"]);
        exit;
    }

    $row = $res->fetch_assoc();
    $storedAnswer = $row['security_answer'];

    // Support both hashed and plain text answers
    if (password_verify($answer, $storedAnswer) || $answer === $storedAnswer) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $upd = $con->prepare("UPDATE signup SET password=? WHERE email=?");
        $upd->bind_param("ss", $hash, $email);
        $upd->execute();

        echo json_encode(["success"=>true]);
        exit;
    } else {
        echo json_encode(["success"=>false,"error"=>"Wrong answer"]);
        exit;
    }
}

echo json_encode(["success"=>false,"error"=>"Invalid step"]);
