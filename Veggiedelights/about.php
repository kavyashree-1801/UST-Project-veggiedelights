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

<style>
body { margin:0; font-family:Poppins, sans-serif; background:#f8f8f8; }

/* ✅ NAVBAR */
.navbar {
  display:flex; justify-content:space-between; align-items:center;
  background:#ff7b00; padding:12px 30px; flex-wrap:wrap;
}
.logo a { font-size:1.6rem; font-weight:bold; color:#fff; text-decoration:none; }
.navbar nav { display:flex; gap:20px; flex-wrap:wrap; }
.navbar nav a {
  color:#fff; text-decoration:none; font-weight:bold;
  padding:6px 10px; border-radius:5px; transition:0.3s;
}
.navbar nav a:hover,
.navbar nav a.active {
  background:#fff; color:#ff7b00;
}

.auth-links { display:flex; align-items:center; gap:12px; }
.welcome { color:#fff; font-weight:bold; }

.profile-icon {
  display:flex; align-items:center; justify-content:center;
  width:38px; height:38px; background:#fff;
  color:#ff8c00; border-radius:50%;
  font-size:20px; font-weight:bold; text-decoration:none;
  transition:0.3s;
}
.profile-icon:hover { background:#ff8c00; color:#fff; }

.nav-link-logout {
  background:#fff; color:#ff8c00; padding:6px 12px;
  border-radius:5px; text-decoration:none; font-weight:bold;
}
.nav-link-logout:hover { background:#ff7b00; color:#fff; }

/* ✅ ABOUT CONTENT */
.about { max-width:1100px; margin:60px auto; padding:20px; text-align:center; line-height:1.8; }
.about h1 { font-size:2.6em; color:#2c3e50; margin-bottom:30px; }
.brand { color:#ff7b00; }

.about-content { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:30px; }
.about-text { flex:1; text-align:left; font-size:1.1em; }
.about-image img {
  width:100%; max-width:400px; border-radius:15px;
  box-shadow:0 4px 15px rgba(0,0,0,0.1);
  transition:0.3s;
}
.about-image img:hover { transform:scale(1.05); }

/* ✅ VALUES */
.value-cards { display:flex; flex-wrap:wrap; justify-content:center; gap:25px; }
.value-card {
  background:#fff8f2; border:1px solid #ffe0c0; border-radius:15px;
  padding:25px; width:280px; transition:0.3s;
}
.value-card:hover { transform:translateY(-5px); }

/* ✅ FOOTER */
footer {
  text-align:center; padding:20px; background:#ff7b00; color:#fff;
  margin-top:60px;
}
</style>
</head>

<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>

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
  <p> © 2025 Veggiedelights |All rights reserved</p>
</footer>

</body>
</html>
