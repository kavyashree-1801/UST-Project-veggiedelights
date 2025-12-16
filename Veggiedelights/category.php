<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recipe Categories | Veggiedelights</title>
<link rel="stylesheet" href="css/category.css">
</head>
<body>

<!-- Navbar -->
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
    <?php
      if(isset($_SESSION['email'])){
        echo '<a href="userprofile.php" class="profile-icon">👤</a>';
        echo '<span class="welcome">👋Hello '.htmlspecialchars($_SESSION['email']).'</span>';
        echo '<a href="logout.php" class="nav-link-logout">Logout</a>';
      } else {
        echo '<a href="login.php" class="nav-link-logout">Login</a>';
      }
    ?>
  </div>
</header>

<!-- Page Header -->
<h1>Recipe Categories</h1>

<!-- Category Container -->
<section class="category-container" id="categoryContainer">
  Loading categories...
</section>

<!-- Footer -->
<footer class="footer">
    © 2025 Veggiedelights | All Rights Reserved 🍽️
</footer>

<!-- JS to load categories dynamically -->
<script src="js/category.js"></script>

</body>
</html>
