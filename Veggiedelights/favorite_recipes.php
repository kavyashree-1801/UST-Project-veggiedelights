<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
$email = $_SESSION['email'] ?? '';
$role = $_SESSION['role'] ?? 'user';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Favorite Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/favorites.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>

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
    <span class="welcome">👋 <?php echo htmlspecialchars($email); ?></span>
    <form action="logout.php" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>
</header>

<!-- ===== MAIN CONTENT ===== -->
<main>
<h1>❤️ My Favorite Recipes</h1>

<section class="recipe-container" id="favContainer">
Loading...
</section>
</main>

<!-- ===== FOOTER ===== -->
<footer>
  © 2025 Veggiedelights | All rights reserved
</footer>

<script src="js/favorite_recipe.js"></script>

</body>
</html>
