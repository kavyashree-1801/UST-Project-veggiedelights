<?php
session_start(); // Must be at the very top

$email = $_SESSION['email'] ?? '';
$role = $_SESSION['role'] ?? 'guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | Veggiedelights</title>
<link rel="stylesheet" href="css/contact.css">
<style>
.contact-container {
    max-width: 500px;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.contact-container h1 {
    text-align: center;
    color: #ff7b00;
    margin-bottom: 20px;
}
.contact-container input,
.contact-container textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0 5px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
.contact-container button {
    width: 100%;
    padding: 12px;
    background: #ff7b00;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}
.contact-container button:hover {
    background: #e05500;
}
.hint {
    font-size: 0.85rem;
    color: gray;
    margin-bottom: 5px;
}
.hint.valid {
    color: green;
}
.hint.invalid {
    color: red;
}
</style>
</head>
<body>

<!-- 🌟 NAVBAR -->
<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="Category.php">Categories</a>
    <a href="contact.php" class="active">Contact</a>
    <a href="feedback.php">Feedback</a>
    <?php if($role === 'user'): ?>
      <a href="my_recipes.php">My Recipes</a>
    <?php endif; ?>
  </nav>
  <div class="auth-links">
    <?php if($role === 'user'): ?>
      <a href="userprofile.php" class="profile-icon">👤</a>
      <span class="welcome">👋 Hello <?= htmlspecialchars($email); ?></span>
      <a href="logout.php" class="nav-link">Logout</a>
    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
    <?php endif; ?>
  </div>
</header>

<!-- 🌸 CONTACT FORM -->
<main>
  <div class="contact-container">
    <h1>📬 Contact Us</h1>
    <form id="contactForm">
      <input type="text" name="name" placeholder="Your Name" required>
      <div id="nameHint" class="hint"></div>

      <input type="email" name="email" placeholder="Your Email" required>
      <div id="emailHint" class="hint"></div>

      <input type="text" name="subject" placeholder="Subject" required>
      <div id="subjectHint" class="hint"></div>

      <textarea name="message" placeholder="Your Message" required></textarea>
      <div id="messageHint" class="hint"></div>

      <button type="submit">Send Message</button>
    </form>
    <div id="formMsg" style="margin-top:10px;"></div>
  </div>
</main>

<footer>
  © 2025 Veggiedelights | All rights reserved 🍽️
</footer>

<script src="js/contact.js"></script>

</body>
</html>
