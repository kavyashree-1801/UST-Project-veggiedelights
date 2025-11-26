<?php
session_start();
include 'db_connect.php'; // same database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Example: your admin table
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['email'] = $admin['email'];
            $_SESSION['role'] = 'admin'; // 🔹 important
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No admin found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login | Veggiedelights</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
      <label>Email:</label>
      <input type="email" name="email" required>
      <label>Password:</label>
      <input type="password" name="password" required>
      <button type="submit">Login</button>
    </form>
    <p><a href="login.php">Login as User</a></p>
  </div>
</body>
</html>
