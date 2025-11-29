<?php
session_start();
include 'config.php';

$email = $_SESSION['email'] ?? null;
$role = $_SESSION['role'] ?? 'guest';

if (!$email) {
    header('Location: login.php');
    exit;
}

// Fetch user info
$sql = "SELECT name, security_question FROM signup WHERE email=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = $user['name'];
$security_question = $user['security_question'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Profile | Veggiedelights</title>

<style>
/* ===================== BACKGROUND + WHITE OVERLAY ===================== */
body {
  margin: 0;
  font-family: "Poppins", sans-serif;
  background: url('https://img.freepik.com/free-photo/top-view-different-seasonings-with-fresh-vegetables-dark-desk-spicy-pepper-food-salad-health_140725-86007.jpg') 
              no-repeat center center fixed;
  background-size: cover;
  padding-top: 110px;
  min-height: 100vh;
  position: relative;
}

body::before {
  content: "";
  position: fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background: rgba(255,255,255,0.75);
  z-index: -1;
}

/* ===================== NAVBAR ===================== */
.navbar {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  padding: 15px 40px;
  background: #ff7b00;
  color: white;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
  box-shadow: 0 2px 10px rgba(0,0,0,0.25);
  font-weight: bold;
}

.navbar .logo a {
  color: white;
  font-size: 26px;
  font-weight: bold;
  text-decoration: none;
}

nav {
  display: flex;
  align-items: center;
  gap: 20px;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: bold;
  padding: 6px 10px;
  border-radius: 5px;
  transition: 0.3s;
}

nav a:hover {
  background: white;
  color: #ff7b00;
}

.auth-links {
  display: flex;
  align-items: center;
  gap: 15px;
}

.welcome {
  color: #fff;
  font-weight: bold;
}

.profile-icon {
  font-size: 1.3rem;
  color:white;
}

/* LOGOUT BUTTON */
.logout-form {
  margin: 0;
}

.logout-btn {
  background: white;
  color: #ff7b00;
  border: none;
  padding: 8px 15px;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

.logout-btn:hover {
  background: #ffe0c2;
  color: #a94f00;
}

/* ===================== PROFILE BOX ===================== */
.profile-container {
    background: rgba(255,255,255,0.97);
    border-radius: 20px;
    padding: 40px;
    width: 100%;
    max-width: 520px;
    margin: auto;
    margin-top: 25px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.profile-container h1 {
    color: #ff7b00;
    text-align: center;
    margin-bottom: 20px;
}

.profile-pic {
    text-align: center;
}

.profile-pic img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 4px solid #ff7b00;
    object-fit: cover;
    margin-bottom: 10px;
}

/* ===================== FORM ===================== */
.input-group {
    margin-bottom: 18px;
}

.input-group label {
    font-weight: 600;
    color: #ff7b00;
    display: block;
    margin-bottom: 6px;
}

.input-group input {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: 2px solid #ddd;
    font-size: 15px;
    transition: 0.3s ease;
    background: white;
}

.input-group input:focus {
    border-color: #ff7b00;
    background: #fff9f1;
    box-shadow: 0 0 6px rgba(255,123,0,0.3);
}

button[type="submit"] {
    background: #ff7b00;
    color: #fff;
    border: none;
    padding: 14px;
    width: 100%;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}

button:hover {
    background: #ff8f20;
}

/* ===================== FOOTER ===================== */
footer {
  background: #ff7b00;
  color: white;
  text-align: center;
  padding: 15px 0;
  font-weight: bold;
  width: 100%;
  position: fixed;
  bottom: 0;
}
</style>
</head>

<body>

<!-- ===================== NAVBAR ===================== -->
<header class="navbar">
  <div class="logo">
    <a href="index.php">🥘 Veggiedelights</a>
  </div>

  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>

  <div class="auth-links">
      <a href="userprofile.php" class="profile-icon">👤</a>
      <span class="welcome">👋 <?= htmlspecialchars($email); ?></span>

      <form action="logout.php" method="POST" class="logout-form">
        <button class="logout-btn">Logout</button>
      </form>
  </div>
</header>

<!-- ===================== PROFILE BOX ===================== -->
<div class="profile-container">
<h1>👤 Your Profile</h1>

<form>
    <div class="profile-pic">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
        <input type="file" accept="image/*">
    </div>

    <div class="input-group">
        <label>Your Name</label>
        <input type="text" value="<?= htmlspecialchars($name) ?>" required>
    </div>

    <div class="input-group">
        <label>Email Address</label>
        <input type="email" value="<?= htmlspecialchars($email) ?>" readonly>
    </div>

    <div class="input-group">
        <label>Security Question</label>
        <input type="text" value="<?= htmlspecialchars($security_question) ?>" required>
    </div>

    <div class="input-group">
        <label>New Security Answer</label>
        <input type="text" placeholder="Enter new answer">
    </div>

    <button type="submit">💾 Save Profile</button>
</form>
</div>

<!-- ===================== FOOTER ===================== -->
<footer>
  © 2025 Veggiedelights | All Rights Reserved
</footer>

</body>
</html>
