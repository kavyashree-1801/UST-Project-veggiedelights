<?php
session_start();
include 'config.php'; // DB connection

$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recipe Categories | Veggiedelights</title>
<style>
body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f0f0f0; }

/* Navbar */
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

/* Category cards */
.category-container { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; padding:20px; }
.category-card { background:#fff; border-radius:10px; overflow:hidden; width:250px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
.category-card img { width:100%; height:160px; object-fit:cover; }
.category-card h2 { margin:10px 0; color:#ff7b00; }
.category-card a.btn { display:inline-block; margin-bottom:15px; padding:8px 15px; background:#ff7b00; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold; }
.category-card a.btn:hover { background:#e06a00; }

h1 { text-align:center; color:#ff7b00; margin:20px 0; }
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

<h1>Recipe Categories</h1>

<section class="category-container">
<?php
$query = "SELECT * FROM categories ORDER BY id ASC";
$result = $con->query($query);

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $name = $row['name'];
        $img = $row['image'];
        echo '<div class="category-card">';
        echo '<img src="'.htmlspecialchars($img).'" alt="'.htmlspecialchars($name).'">';
        echo '<h2>'.htmlspecialchars($name).'</h2>';
        echo '<a href="category_recipes.php?cat='.urlencode($name).'" class="btn">View Recipes</a>';
        echo '</div>';
    }
} else {
    echo "<p style='text-align:center;color:#555;'>No categories found.</p>";
}
?>
</section>

</body>
</html>
