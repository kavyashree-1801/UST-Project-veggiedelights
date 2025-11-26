<?php
session_start();
include 'config.php'; // $con is your DB connection

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// Fetch favorite recipes (case-insensitive email matching)
$sql = "
    SELECT r.* 
    FROM recipes r
    INNER JOIN favorites f ON r.id = f.recipe_id
    WHERE LOWER(f.email) = LOWER(?)
    ORDER BY r.id DESC
";

$stmt = $con->prepare($sql);
if(!$stmt){
    die("Prepare failed: ".$con->error);
}

$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$favorites = [];
while ($row = $result->fetch_assoc()) {
    $favorites[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Favorite Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/styles.css">
<style>
/* ===== Navbar ===== */
header.navbar {
  display: flex; justify-content: space-between; align-items: center;
  padding: 15px 30px; background: #ff7b00; color: #fff; flex-wrap: wrap;
  border-radius: 0 0 10px 10px;
}
header.navbar .logo a { font-size: 1.5rem; font-weight: bold; color: #fff; text-decoration: none; }
header.navbar nav { display: flex; gap: 15px; flex-wrap: wrap; }
header.navbar nav a { color: #fff; text-decoration: none; padding: 8px 12px; border-radius: 6px; font-weight: bold; transition: all 0.3s; }
header.navbar nav a:hover { background: #fff; color: #ff7b00; }
.auth-links { display: flex; align-items: center; gap: 10px; }
.auth-links a { color: #ff7b00; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-weight: bold; transition: all 0.3s; }
.auth-links a:hover { background: #fff; color: #ff7b00; }
#themeToggle { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #fff; transition: all 0.3s; }
#themeToggle:hover { color: #333; }

/* ===== Page Container ===== */
.container { max-width: 1000px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
h1 { text-align: center; color: #ff7b00; }
.recipe-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
.recipe-card { background: #f9f9f9; padding: 15px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-align: center; position: relative; transition: all 0.3s ease; cursor: pointer; }
.recipe-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
.recipe-card h3 { margin: 0 0 10px; color: #333; }
.recipe-card p.description { font-size: 0.95rem; color: #555; margin-bottom: 10px; }
.recipe-card:hover { transform: scale(1.05); background: #ff7b00; color: #fff; }
.recipe-card:hover h3 { color: #fff; }
.recipe-card:hover p.description { color: #fff; }

/* Heart Icon */
.heart { font-size: 24px; color: #e74c3c; cursor: pointer; position: absolute; top: 10px; right: 10px; z-index: 10; }

/* Back Button */
a.back { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #ff7b00; color: #fff; text-decoration: none; border-radius: 6px; transition: all 0.3s ease; }
a.back:hover { background: #fff; color: #ff7b00; }
</style>
</head>
<body>
<header class="navbar">
  <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>
  <div class="auth-links">
    <span class="welcome">👋 <?= htmlspecialchars($user_email); ?></span>
    <a href="logout.php">Logout</a>
    <button id="themeToggle">🌙</button>
  </div>
</header>

<div class="container">
  <h1>Favorite Recipes</h1>
  <p>Your saved favorite recipes will appear below:</p>

  <div class="recipe-list" id="recipeList">
    <?php if (!empty($favorites)) : ?>
      <?php foreach ($favorites as $recipe) : ?>
        <div class="recipe-card">
          <span class="heart" data-id="<?= $recipe['id']; ?>">♥</span>
          <img src="<?= htmlspecialchars($recipe['image']); ?>" alt="<?= htmlspecialchars($recipe['name']); ?>">
          <h3><?= htmlspecialchars($recipe['name']); ?></h3>
          <p class="description"><?= htmlspecialchars($recipe['description']); ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No favorite recipes yet. <a href="category.php">Browse Recipes</a></p>
    <?php endif; ?>
  </div>

  <a href="index.php" class="back">← Back to Home</a>
</div>

<script>
// Remove favorite on heart click
document.querySelectorAll('.heart').forEach(heart=>{
  heart.addEventListener('click', e=>{
    e.stopPropagation(); // prevent card click
    const recipeId = heart.dataset.id;

    fetch('toggle_favorite.php', {
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:'recipe_id='+recipeId
    })
    .then(res=>res.text())
    .then(res=>{
      if(res==='removed'){
        heart.parentElement.remove(); // remove card from page
      } else if(res==='added'){
        heart.classList.add('favorited');
      } else {
        alert(res);
      }
    });
  });
});
</script>
</body>
</html>
