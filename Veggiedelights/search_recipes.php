<?php
session_start();
include 'config.php'; // Your DB connection in $con

$searchTerm = '';
$recipes = [];

if (isset($_GET['q'])) {
    $searchTerm = trim($_GET['q']);

    $stmt = $con->prepare("SELECT * FROM recipes WHERE name LIKE ? ORDER BY id DESC");
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
    $stmt->close();
} else {
    $result = $con->query("SELECT * FROM recipes ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Recipes | Veggiedelights</title>

<style>

/* ===================== BACKGROUND + OVERLAY ===================== */
body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  background: url('https://thumbs.dreamstime.com/b/food-background-healthy-vegetarian-cooking-ingredients-tasty-pumpkin-dishes-recipes-bowls-tomato-sauces-spinach-sli-sliced-103694414.jpg') no-repeat center center fixed;
  background-size: cover;
  position: relative;
  z-index: 1;
}

body::before {
  content: "";
  position: fixed;
  top:0; left:0;
  width:100%; height:100%;
  background: rgba(255,255,255,0.7); /* White overlay */
  z-index: -1;
}

/* ===================== Navbar ===================== */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  background: #ff7b00;
  color: white;
  position: sticky;
  top: 0;
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
  font-weight: bold; /* BOLD NAV ITEMS */
  padding: 6px 10px;
  border-radius: 5px;
  transition: 0.3s;
}

nav a:hover,
nav a.active {
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

/* ===================== Main ===================== */

main {
  max-width: 1200px;
  margin: 40px auto 60px;
  padding: 0 20px;
  position: relative;
  z-index: 1;
}

.search-form {
  text-align: center;
  margin-bottom: 30px;
}

.search-form input {
  width: 320px;
  padding: 12px;
  border-radius: 5px;
  border: 2px solid #ccc;
  font-size: 16px;
}

.search-form button {
  padding: 12px 20px;
  background: #ff7b00;
  border: none;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
}

.search-form button:hover {
  background: #e86e00;
}

/* ===================== Recipe Cards ===================== */

.recipe-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
}

.recipe-card {
  background: white;
  width: 350px;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: 0.3s;
}

.recipe-card:hover {
  transform: translateY(-5px);
}

.recipe-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.recipe-content {
  padding: 15px 20px;
}

.recipe-content h2 {
  margin: 0 0 10px;
  color: #ff7b00;
}

.no-results {
  text-align: center;
  color: #444;
  font-size: 18px;
  margin-top: 30px;
}

/* ===================== Footer ===================== */

footer {
  background: #ff7b00;
  text-align: center;
  color: white;
  padding: 20px;
  margin-top: 40px;
  font-weight: bold;
}

/* ===================== Responsive ===================== */
@media(max-width: 768px) {
  nav { gap: 10px; flex-wrap: wrap; }
  .recipe-card { width: 90%; }
}
</style>
</head>

<body>

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
    <?php if (!empty($_SESSION['email'])): ?>
      <a href="userprofile.php" class="profile-icon">👤</a>
      <span class="welcome">👋 <?= htmlspecialchars($_SESSION['email']); ?></span>

      <!-- LOGOUT BUTTON -->
      <form action="logout.php" method="POST" class="logout-form">
        <button class="logout-btn">Logout</button>
      </form>

    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
    <?php endif; ?>
  </div>
</header>

<main>

  <form class="search-form" method="GET">
    <input type="text" name="q" placeholder="Enter recipe name" value="<?= htmlspecialchars($searchTerm); ?>">
    <button type="submit">Search</button>
  </form>

  <div class="recipe-container">
    <?php if (!empty($recipes)): ?>
      <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
          <img src="<?= htmlspecialchars($recipe['image']) ?: 'placeholder.png' ?>">
          <div class="recipe-content">
            <h2><?= htmlspecialchars($recipe['name']) ?></h2>
            <p><?= htmlspecialchars($recipe['description']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="no-results">No recipes found.</p>
    <?php endif; ?>
  </div>

</main>

<footer>
  © 2025 Veggiedelights | All rights reserved
</footer>

</body>
</html>
