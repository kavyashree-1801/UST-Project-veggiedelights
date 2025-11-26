<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

$email = $_SESSION['email'] ?? null;
if (!$email) {
    echo json_encode(['success'=>false,'message'=>'Not logged in.']);
    exit;
}

$name = $_POST['name'] ?? '';
$security_question = $_POST['security_question'] ?? '';
$security_answer = $_POST['security_answer'] ?? '';

if (empty($name) || empty($security_question)) {
    echo json_encode(['success'=>false,'message'=>'Name and Security Question are required.']);
    exit;
}

if(!empty($security_answer)) {
    $sql = "UPDATE signup SET name=?, security_question=?, security_answer=? WHERE email=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss",$name,$security_question,$security_answer,$email);
} else {
    $sql = "UPDATE signup SET name=?, security_question=? WHERE email=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss",$name,$security_question,$email);
}

if($stmt->execute()){
    echo json_encode(['success'=>true,'message'=>'Profile updated successfully!']);
}else{
    echo json_encode(['success'=>false,'message'=>'Failed to update profile.']);
}
