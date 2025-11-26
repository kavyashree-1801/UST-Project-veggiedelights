<?php
session_start();
include 'config.php';  // DB CONNECTION

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $security_question = $_POST['security_question'];
    $security_answer = trim($_POST['security_answer']);
    $captcha = $_POST['captcha'];

    // 1️⃣ Confirm Password Validation
    if ($password !== $confirm_password) {
        die("<script>alert('Passwords do NOT match!'); window.history.back();</script>");
    }

    // 2️⃣ CAPTCHA Validation
    if ($captcha != $_SESSION['captcha_answer']) {
        die("<script>alert('Incorrect CAPTCHA answer! Try again.'); window.history.back();</script>");
    }

    // 3️⃣ Check if email already exists
    $check = mysqli_query($con, "SELECT * FROM signup WHERE email='$email' LIMIT 1");
    if (mysqli_num_rows($check) > 0) {
        die("<script>alert('Email already exists! Try a different one.'); window.history.back();</script>");
    }

    // 4️⃣ Handle file upload
    $profile_pic = "";

    if (!empty($_FILES['profile_pic']['name'])) {

        $fileName = $_FILES['profile_pic']['name'];
        $tmpName = $_FILES['profile_pic']['tmp_name'];
        $fileSize = $_FILES['profile_pic']['size'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed extensions
        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($fileType, $allowed)) {
            die("<script>alert('Only JPG, JPEG, PNG files allowed!'); window.history.back();</script>");
        }

        // Unique name
        $newName = "IMG_" . time() . "." . $fileType;

        // Upload directory
        $uploadPath = "uploads/" . $newName;

        if (!move_uploaded_file($tmpName, $uploadPath)) {
            die("<script>alert('Image upload failed!'); window.history.back();</script>");
        }

        $profile_pic = $newName;
    }

    // 5️⃣ Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Default role
    $role = "user";

    // 6️⃣ Insert into database
    $query = "INSERT INTO signup (name, email, password, security_question, security_answer, role, profile_pic) 
              VALUES ('$name', '$email', '$hashedPassword', '$security_question', '$security_answer', '$role', '$profile_pic')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Account Created Successfully!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Something went wrong: " . mysqli_error($con) . "'); window.history.back();</script>";
    }

}
?>
