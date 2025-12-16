<?php
session_start();
include 'config.php';

// Set role and email
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? $_SESSION['username'] ?? 'Guest';

// Greeting based on time
date_default_timezone_set('Asia/Kolkata');
$hour = date('H');
if ($hour < 12) $greeting = "Good Morning";
elseif ($hour < 17) $greeting = "Good Afternoon";
elseif ($hour < 20) $greeting = "Good Evening";
else $greeting = "Good Night";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Veggiedelights</title>
<link rel="stylesheet" href="css/index.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo">
    <a href="index.php">🥘 Veggiedelights</a>
  </div>
  <nav>
    <!-- ===== USER NAV ===== -->
    <?php if ($role === 'user'): ?>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="category.php">Categories</a>
      <a href="contact.php">Contact</a>
      <a href="feedback.php">Feedback</a>
      <a href="my_recipes.php">My Recipes</a>

    <!-- ===== ADMIN NAV ===== -->
    <?php elseif ($role === 'admin'): ?>
      <a href="index.php"class="active">Home</a>
      <a href="manage_categories.php">Manage Categories</a>
      <a href="view_contact.php">Manage Contact</a>
      <a href="view_feedback.php">Manage Feedback</a>
      <a href="view_recipes.php">Manage Recipes</a>
      <a href="view_users.php">Manage Users</a>
    <?php endif; ?>
  </nav>

  <div class="auth-links">
    <?php if ($role === 'user'): ?>
      <a href="userprofile.php" class="profile-btn">👤</a>
      <span class="welcome">👋 Hello <?= htmlspecialchars($email); ?></span>
      <a href="logout.php">Logout</a>

    <?php elseif ($role === 'admin'): ?>
      <span class="welcome">👋 Hello Admin</span>
      <a href="logout.php">Logout</a>

    <?php else: ?>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </div>
</header>

<!-- ===== HERO SECTION ===== -->
<section class="hero">
  <div class="overlay">
    <?php if ($role === 'user'): ?>
      <h1><?= $greeting; ?>, <?= htmlspecialchars($email); ?>!</h1>
      <p>Explore delicious vegetarian recipes curated just for you!</p>

      <div class="user-cards">
        <a href="search_recipes.php" class="user-action-card">
          <h3>🔍 Search Recipe</h3>
          <p>Find your favorite vegetarian dishes easily.</p>
        </a>

        <a href="add_recipe.php" class="user-action-card">
          <h3>➕ Add Recipe</h3>
          <p>Share your own recipes with the community.</p>
        </a>

        <a href="favorite_recipes.php" class="user-action-card">
          <h3>❤️ Favourite Recipes</h3>
          <p>Quickly access your saved recipes.</p>
        </a>
      </div>

    <?php elseif ($role === 'admin'): ?>
      <h1><?= $greeting; ?>, Admin 👋</h1>
      <p>Manage and monitor your Veggiedelights platform efficiently.</p>

    <?php else: ?>
      <h1><?= $greeting; ?>! Welcome to Veggiedelights 🥘</h1>
      <p>Discover and share amazing vegetarian recipes!</p>
    <?php endif; ?>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved 🍽️</p>
</footer>

</body>
</html>
