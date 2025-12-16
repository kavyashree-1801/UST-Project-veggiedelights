<?php
session_start();
include '../config.php';

header('Content-Type: application/json');

$email = $_SESSION['email'] ?? null;
if(!$email){
    echo json_encode(['success'=>false,'msg'=>'Not logged in']);
    exit;
}

$name = $_POST['name'] ?? '';
$security_answer = $_POST['security_answer'] ?? '';
$profile_pic_path = '';

if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] !== ''){
    $targetDir = "../uploads/profiles/";
    if(!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $fileName = time().'_'.basename($_FILES['profile_pic']['name']);
    $targetFile = $targetDir.$fileName;
    if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)){
        $profile_pic_path = 'uploads/profiles/'.$fileName;
    }
}

$sql = "UPDATE signup SET name=?, security_answer=?";
$params = [$name, $security_answer];
$types = "ss";

if($profile_pic_path){
    $sql .= ", profile_pic=?";
    $types .= "s";
    $params[] = $profile_pic_path;
}

$sql .= " WHERE email=?";
$types .= "s";
$params[] = $email;

$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);

if($stmt->execute()){
    echo json_encode(['success'=>true,'msg'=>'Profile updated successfully!','profile_pic'=>$profile_pic_path]);
} else {
    echo json_encode(['success'=>false,'msg'=>'Failed to update profile']);
}
