<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email_reset'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['email_reset'];
$question = $_SESSION['security_question'];
$name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answer = trim($_POST['security_answer']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
        $msg_type = "error";
    } else {
        $stmt = $con->prepare("SELECT security_answer FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($answer, $row['security_answer'])) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $con->prepare("UPDATE signup SET password = ? WHERE email = ?");
            $update->bind_param("ss", $hashed_new_password, $email);
            if ($update->execute()) {
                session_destroy();
                $message = "Password reset successful! Redirecting to login...";
                $msg_type = "success";
                $redirect = true;
            } else {
                $message = "Something went wrong. Try again!";
                $msg_type = "error";
            }
        } else {
            $message = "Incorrect answer. Please try again.";
            $msg_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password | Veggiedelights</title>
<style>
body {
    font-family: "Poppins", sans-serif;
    background: url('your-bg-image.jpg') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    position: relative;
}
body::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.3);
    z-index: 1;
}
.reset-box {
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    padding: 35px 40px;
    text-align: center;
    z-index: 2;
    max-width: 380px;
    width: 90%;
}
h2 { color: #ff7b00; margin-bottom: 10px; }
p { color: #333; margin-bottom: 20px; }
.input-wrapper {
    position: relative;
    margin: 10px 0;
}
input {
    width: 100%;
    padding: 10px 40px 10px 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 1rem;
}
.eye-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 1.1rem;
    color: #888;
}
button {
    background: #ff7b00;
    color: #fff;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
button:hover { background: #ff8f26; }
.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    display: none;
    position: absolute;
    top: -70px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 320px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    font-weight: bold;
}
.alert.error { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
.alert.success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
</style>
</head>
<body>
<div class="reset-box">
    <h2>Hello, <?= htmlspecialchars($name) ?>!</h2>
    <p><strong>Security Question:</strong><br><?= htmlspecialchars($question) ?></p>

    <!-- Alert box -->
    <div id="alertBox" class="alert <?= isset($msg_type) ? $msg_type : '' ?>">
        <?= isset($message) ? htmlspecialchars($message) : '' ?>
    </div>

    <form method="POST">
        <input type="text" name="security_answer" placeholder="Your answer" required><br>

        <div class="input-wrapper">
            <input type="password" name="new_password" id="new_password" placeholder="New password" required>
            <span class="eye-toggle" onclick="togglePassword('new_password')">&#128065;</span>
        </div>

        <div class="input-wrapper">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
            <span class="eye-toggle" onclick="togglePassword('confirm_password')">&#128065;</span>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</div>

<script>
// Show alert and handle redirect
const alertBox = document.getElementById('alertBox');
if(alertBox.innerHTML.trim() !== '') {
    alertBox.style.display = 'block';

    <?php if(isset($redirect) && $redirect): ?>
        setTimeout(() => {
            window.location.href = "login.php";
        }, 2500);
    <?php else: ?>
        setTimeout(() => { alertBox.style.display = 'none'; }, 3000);
    <?php endif; ?>
}

// Password eye toggler
function togglePassword(id) {
    const input = document.getElementById(id);
    if(input.type === "password") input.type = "text";
    else input.type = "password";
}
</script>
</body>
</html>
