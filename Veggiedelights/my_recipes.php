<?php
session_start(); // Start session at the top of the page
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/myrecipes.css">

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
    <?php
      if(isset($_SESSION['email'])){
          echo '<a href="userprofile.php" class="profile-icon">👤</a>';
          echo '<span class="welcome">👋 Hello '.htmlspecialchars($_SESSION['email']).'</span>';
          echo '<a href="logout.php" class="nav-link-logout">Logout</a>';
      } else {
          echo '<a href="login.php" class="nav-link-logout">Login</a>';
      }
    ?>
  </div>
</header>

<!-- ===== Page Heading ===== -->
<h1>My Recipes</h1>

<!-- ===== Recipe Container ===== -->
<div class="recipe-container" id="recipeContainer">
    <p>Loading recipes...</p>
</div>

<!-- ===== Footer ===== -->
<footer class="footer">
    © 2025 Veggiedelights | All Rights Reserved 🍽️
</footer>

<!-- ===== Scripts ===== -->
<script src="js/my_recipes.js"></script>

</body>
</html>
