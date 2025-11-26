<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    $stmt = $con->prepare("SELECT security_question, name FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['email_reset'] = $email;
        $_SESSION['security_question'] = $row['security_question'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: answer_security_question.php");
        exit;
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | Veggiedelights</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: url('https://img.freepik.com/free-photo/top-view-lemon-slices-with-candies-fruits_140725-57946.jpg?semt=ais_hybrid&w=740&q=80') no-repeat center center/cover;
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
    .forgot-box {
      background: rgba(255,255,255,0.95);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      padding: 35px 40px;
      text-align: center;
      z-index: 2;
      max-width: 380px;
      width: 90%;
    }
    h2 {
      color: #ff7b00;
      margin-bottom: 20px;
    }
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
      transition: 0.3s;
    }
    button:hover {
      background: #ff8f26;
    }
    a {
      color: #ff7b00;
      text-decoration: none;
      font-weight: 500;
    }
    p.error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="forgot-box">
    <h2>Forgot Password</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Enter your email" required><br>
      <button type="submit">Next</button>
    </form>
    <p><a href="login.php">Back to Login</a></p>
  </div>
</body>
</html>
