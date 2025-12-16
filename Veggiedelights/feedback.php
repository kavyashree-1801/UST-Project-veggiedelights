<?php
session_start();
$email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback | Veggiedelights</title>
<link rel="stylesheet" href="css/feedback.css">
<style>
/* Simple live hint styles */
label { display:block; margin-top:10px; font-weight:500; }
.hint { font-size:0.85rem; margin-bottom:5px; color: gray; }
.hint.valid { color: green; }
.hint.invalid { color: red; }
</style>
</head>
<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php" class="active">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>
  <div class="auth-links">
    <?php if(!empty($email)): ?>
      <a href="userprofile.php" class="profile-icon" title="Your Profile">👤</a>
      <span class="welcome">👋 Hello <?= htmlspecialchars($email); ?></span>
      <form action="logout.php" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
    <?php endif; ?>
  </div>
</header>

<main>
  <h1>💬 We Value Your Feedback!</h1>
  <p class="subtext">Share your thoughts and help us make Veggiedelights even better 🌱</p>

  <form id="feedbackForm">
    <label>Your Name</label>
    <input type="text" name="name" placeholder="Enter your name" required>
    <div id="nameHint" class="hint"></div>

    <label>Your Email</label>
    <input type="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($email); ?>" required>
    <div id="emailHint" class="hint"></div>

    <label>Your Rating</label>
    <select name="rating" required>
      <option value="">Select Rating</option>
      <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
      <option value="4">⭐⭐⭐⭐ Good</option>
      <option value="3">⭐⭐⭐ Average</option>
      <option value="2">⭐⭐ Poor</option>
      <option value="1">⭐ Very Poor</option>
    </select>
    <div id="ratingHint" class="hint"></div>

    <label>Your Feedback</label>
    <textarea name="message" rows="5" placeholder="Tell us about your experience..." required></textarea>
    <div id="messageHint" class="hint"></div>

    <button type="submit">📨 Submit Feedback</button>
  </form>
</main>

<footer>
  <p>© 2025 Veggiedelights | All rights reserved 🍽️</p>
</footer>

<script src="js/feedback.js"></script>

</body>
</html>
