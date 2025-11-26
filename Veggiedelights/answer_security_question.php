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

    $answer = trim(strtolower($_POST['security_answer']));
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {

        $stmt = $con->prepare("SELECT security_answer FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {

            $stored_answer = trim(strtolower($row['security_answer']));

            // ✅ Case-insensitive matching
            if ($answer === $stored_answer) {

                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update = $con->prepare("UPDATE signup SET password = ? WHERE email = ?");
                $update->bind_param("ss", $hashed_new_password, $email);
                $update->execute();

                session_destroy();
                $success = "Password reset successful! Redirecting to login...";
            } else {
                $error = "Incorrect answer. Please try again.";
            }
        } else {
            $error = "User not found!";
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
      background: url('https://t3.ftcdn.net/jpg/05/15/82/20/360_F_515822014_L4aurIrqCks24haCUIPSWpZ2VX9ls0Q6.jpg') no-repeat center center/cover;
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
    input {
      width: 100%;
      padding: 10px 12px;
      margin: 10px 0;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1rem;
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
      margin-top: 10px;
    }
  </style>
</head>

<body>

  <div class="reset-box">
    <h2>Hello, <?= htmlspecialchars($name) ?>!</h2>
    <p><strong>Security Question:</strong><br><?= htmlspecialchars($question) ?></p>

    <form method="POST">
      <input type="text" name="security_answer" placeholder="Your answer" required><br>

      <input type="password" name="new_password" placeholder="New password" required>
      <input type="password" name="confirm_password" placeholder="Confirm password" required>

      <button type="submit">Reset Password</button>
    </form>
  </div>

  <script>
    <?php if(isset($error)): ?>
      alert("<?= addslashes($error) ?>");
    <?php endif; ?>

    <?php if(isset($success)): ?>
      alert("<?= addslashes($success) ?>");
      setTimeout(() => {
        window.location.href = "login.php";
      }, 1000);
    <?php endif; ?>
  </script>

</body>
</html>
