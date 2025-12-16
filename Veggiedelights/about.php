<?php
session_start();
include 'config.php';

$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us | Veggiedelights</title>
  <link rel="stylesheet" href="css/about.css">
</head>

<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>

  <nav>
    <a href="index.php">Home</a>
    <a href="about.php" class="active">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>

  <div class="auth-links">
    <?php if ($role === 'admin'): ?>
      <span class="welcome">👋 Hello Admin</span>
      <a href="logout.php" class="nav-link-logout">Logout</a>

    <?php elseif ($role === 'user'): ?>
      <a href="userprofile.php" class="profile-icon" title="Your Profile">👤</a>
      <span class="welcome">👋 Hello <?= htmlspecialchars($email); ?></span>
      <a href="logout.php" class="nav-link-logout">Logout</a>

    <?php else: ?>
      <a href="login.php" class="nav-link-logout">Login</a>
      <a href="admin_login.php" class="nav-link-logout">Admin</a>
    <?php endif; ?>
  </div>
</header>

<!-- ✅ ABOUT SECTION CONTENT BELOW -->
<main>
  <section class="about">
    <h1>About <span class="brand">Veggiedelights</span></h1>

    <div class="about-content">
      <div class="about-text">
        <p>Welcome to <strong>Veggiedelights</strong> — your happy corner for everything vegetarian! 🌿</p>
        <p>Explore recipes, share your own, save favorites & discover flavors across India and beyond.</p>
        <p>Let’s make healthy eating a delicious celebration! 🥦🍅🥕</p>
      </div>

      <div class="about-image">
        <img src="https://res.cloudinary.com/hz3gmuqw6/image/upload/c_fill,f_auto,q_60,w_750/v1/classpop/676136f4c8c7a" alt="Vegetarian dishes" />
      </div>
    </div>

    <div class="value-cards">
      <div class="value-card"><h3>🌱 Freshness</h3><p>Natural and wholesome ingredients.</p></div>
      <div class="value-card"><h3>💚 Community</h3><p>Food lovers inspiring each other.</p></div>
      <div class="value-card"><h3>🌎 Sustainability</h3><p>Plant-based living for a better planet.</p></div>
    </div>

  </section>
</main>

<footer>
  <p> © 2025 Veggiedelights |All rights reserved 🍽️</p>
</footer>

</body>
</html>
