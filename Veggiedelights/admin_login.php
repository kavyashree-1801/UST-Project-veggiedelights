<?php
session_start();
error_reporting(0);

// Replace with your admin credentials
$admin_email = "admin@veggiedelights.com";
$admin_password = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === $admin_email && $password === $admin_password) {
        // Set admin session
        $_SESSION['admin_email'] = $email;
        $_SESSION['role'] = 'admin'; // <-- Added role for admin
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Veggiedelights</title>
<style>
body {
  font-family: 'Arial', sans-serif;
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: url('https://img.freepik.com/free-photo/top-view-cooked-italian-pasta-with-meat-different-seasonings-dark-blue-surface_140725-61959.jpg?semt=ais_hybrid&w=740&q=80') no-repeat center center fixed;
  background-size: cover;
  position: relative;
}
body::before {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
  z-index: 0;
}
.login-container {
  position: relative;
  z-index: 1;
  width: 360px;
  background: rgba(255, 255, 255, 0.95);
  padding: 40px 30px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.3);
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 15px;
}
.login-container h2 {
  margin-bottom: 25px;
  color: #ff7b00;
  font-size: 26px;
}
input[type="email"], input[type="password"] {
  width: 100%;
  padding: 12px 14px;
  margin: 5px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  transition: border-color 0.3s;
  box-sizing: border-box;
}
input:focus {
  border-color: #ff7b00;
  outline: none;
}
.password-field {
  position: relative;
  margin-top: 10px;
}
.toggle-password {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  width: 22px;
  height: 22px;
  fill: #888;
  transition: fill 0.2s, transform 0.2s;
}
.toggle-password:hover {
  fill: #ff7b00;
  transform: translateY(-50%) scale(1.1);
}
button {
  width: 100%;
  padding: 12px;
  background: #ff7b00;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  margin-top: 20px;
  transition: background 0.3s, transform 0.2s;
}
button:hover {
  background: #e96b00;
  transform: scale(1.03);
}
.error {
  color: red;
  margin-bottom: 10px;
  font-weight: bold;
}
.back-link {
  display: block;
  margin-top: 20px;
  text-decoration: none;
  color: #333;
  font-weight: bold;
  font-size: 14px;
  transition: color 0.3s;
}
.back-link:hover {
  color: #ff7b00;
}
</style>
</head>
<body>

<div class="login-container">
  <h2>🔒 Admin Login</h2>

  <?php if (!empty($error)): ?>
    <p class="error"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="email" name="email" placeholder="Admin Email" required>

    <div class="password-field">
      <input type="password" name="password" id="password" placeholder="Password" required>
      <svg id="eyeOpen" class="toggle-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
        <circle cx="12" cy="12" r="2.5"/>
      </svg>

      <svg id="eyeClosed" class="toggle-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:none;">
        <path d="M12 6c3.89 0 7.25 2.24 8.94 6-1.69 3.76-5.05 6-8.94 6-3.89 0-7.25-2.24-8.94-6C4.75 8.24 8.11 6 12 6zm0-2C7 4 2.73 7.11 1 11c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zM4.27 3L3 4.27l3.18 3.18C4.73 8.24 3.27 9.99 2.06 12c1.63 2.85 4.49 5.27 8.08 5.9l1.42 1.42L21 19.73 19.73 18 4.27 3z"/>
      </svg>
    </div>

    <button type="submit">Login</button>
  </form>

  <a href="index.php" class="back-link">← Back to Home</a>
</div>

<script>
const passwordInput = document.getElementById('password');
const eyeOpen = document.getElementById('eyeOpen');
const eyeClosed = document.getElementById('eyeClosed');

eyeOpen.addEventListener('click', () => {
  passwordInput.type = 'text';
  eyeOpen.style.display = 'none';
  eyeClosed.style.display = 'block';
});

eyeClosed.addEventListener('click', () => {
  passwordInput.type = 'password';
  eyeClosed.style.display = 'none';
  eyeOpen.style.display = 'block';
});
</script>

</body>
</html>
