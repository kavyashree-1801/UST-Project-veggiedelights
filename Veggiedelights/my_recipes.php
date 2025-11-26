<?php 
session_start();
include 'config.php';
error_reporting(0);

// Redirect if not logged in
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$role = $_SESSION['role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>My Recipes | Veggiedelights</title>

<style>
body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f0f0f0; }

/* ✅ SAME NAVBAR AS category_recipes.php */
.navbar { display:flex; justify-content:space-between; align-items:center; background:#ff8c00; padding:12px 30px; flex-wrap:wrap; }
.navbar .logo a { font-size:1.5rem; font-weight:bold; color:#fff; text-decoration:none; }
.navbar nav { display:flex; align-items:center; gap:20px; flex-wrap:wrap; }
.navbar nav a { color:#fff; text-decoration:none; font-weight:bold; padding:6px 10px; border-radius:5px; transition:0.3s; }
.navbar nav a:hover { background:#fff; color:#ff8c00; }

.auth-links { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.auth-links .welcome { color:#fff; font-weight:bold; }
.profile-icon { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#fff; color:#ff8c00; border-radius:50%; font-size:20px; font-weight:bold; text-decoration:none; transition:0.3s; }
.profile-icon:hover { background:#ff8c00; color:#fff; }
.nav-link-logout { background:#fff; color:#ff8c00; padding:6px 12px; border-radius:5px; text-decoration:none; font-weight:bold; transition:0.3s; }
.nav-link-logout:hover { background:#ff8c00; color:#fff; }

/* Page content */
.recipe-page h1 { text-align:center; color:#ff7b00; margin:20px 0; }
.recipe-container { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; padding:20px; }
.recipe-card { background:#fff; width:300px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden; display:flex; flex-direction:column; }
.recipe-card img { width:100%; height:180px; object-fit:cover; }
.recipe-details { padding:15px; flex:1; }
.recipe-card h2 { margin:0 0 10px; color:#ff7b00; font-size:1.2rem; }
.view-button, .delete-btn { display:block; text-align:center; padding:10px; margin:8px; border-radius:6px; font-weight:bold; text-decoration:none; }
.view-button { background:#007bff; color:#fff; }
.delete-btn { background:#dc3545; color:#fff; }

footer { text-align:center; padding:15px; background:#222; color:#fff; margin-top:30px; }
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
    <a href="my_recipes.php" class="active">My Recipes</a>
  </nav>

  <div class="auth-links">
    <?php if ($role === 'admin'): ?>
      <span class="welcome">👋 Hello Admin</span>
      <a href="logout.php" class="nav-link-logout">Logout</a>

    <?php elseif ($role === 'user'): ?>
      <a href="userprofile.php" class="profile-icon">👤</a>
      <span class="welcome">👋 Hello <?= htmlspecialchars($email); ?></span>
      <a href="logout.php" class="nav-link-logout">Logout</a>

    <?php else: ?>
      <a href="login.php" class="nav-link-logout">Login</a>
      <a href="admin_login.php" class="nav-link-logout">Admin</a>
    <?php endif; ?>
  </div>
</header>

<main>
<section class="recipe-page">
  <h1>My Recipes</h1>

  <?php if(isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <p style="color:green;text-align:center;">✅ Recipe deleted successfully!</p>
  <?php endif; ?>

  <div class="recipe-container">

    <?php
    $stmt = $con->prepare("SELECT id, name, image, description FROM recipes WHERE email = ? ORDER BY id DESC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<div class="recipe-card">';
            echo '<img src="'.htmlspecialchars($row['image']).'" alt="'.htmlspecialchars($row['name']).'">';
            echo '<div class="recipe-details">';
            echo '<h2>'.htmlspecialchars($row['name']).'</h2>';
            echo '<p>'.htmlspecialchars(substr($row['description'],0,120)).'...</p>';
            echo '</div>';
            echo '<a href="recipe.php?id='.$row['id'].'" class="view-button">View Recipe</a>';
            echo '<a href="delete_recipe.php?id='.$row['id'].'" class="delete-btn" onclick="return confirm(\'Are you sure?\')">Delete Recipe</a>';
            echo '</div>';
        }
    } else {
        echo '<p style="text-align:center;color:#777;">No recipes added yet. 🍽️</p>';
    }

    $stmt->close();
    ?>
  </div>
</section>
</main>

<footer>
  <p>Made with ❤️ by You | © 2025 Veggiedelights</p>
</footer>

</body>
</html>
