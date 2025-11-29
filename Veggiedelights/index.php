<?php
session_start();

// Default role and email
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';

// Personalized greeting based on time
date_default_timezone_set('Asia/Kolkata');
$hour = date('H');
if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 17) {
    $greeting = "Good Afternoon";
} elseif ($hour < 20) {
    $greeting = "Good Evening";
} else {
    $greeting = "Good Night";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Veggiedelights</title>
<link rel="stylesheet" href="css/styles.css" />
<style>
/* ====== NAVBAR ====== */
header.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #ff7b00;
  padding: 12px 20px;
  flex-wrap: wrap;
}
header.navbar .logo a {
  font-size: 1.5rem;
  font-weight: bold;
  color: #fff;
  text-decoration: none;
}
header.navbar nav {
  display: flex;
  align-items: center;
  gap: 25px;
}
header.navbar nav a {
  color: #fff;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 5px;
  transition: 0.3s;
}
header.navbar nav a:hover {
  background: #fff;
  color: #ff7b00;
}
.dropdown {
  position: relative;
}
.dropdown-content {
  display: none;
  position: absolute;
  top: 45px;
  left: 0;
  background-color: #ff7b00;
  min-width: 180px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  flex-direction: column;
  z-index: 10;
}
.dropdown-content a {
  color: #fff;
  padding: 10px 15px;
  text-decoration: none;
  border-bottom: 1px solid rgba(255,255,255,0.2);
}
.dropdown-content a:hover {
  background: #fff;
  color: #ff7b00;
}
.dropdown:hover .dropdown-content {
  display: flex;
}
.auth-links {
  display: flex;
  align-items: center;
  gap: 10px;
}
.nav-link {
  background: #fff;
  color: #ff7b00;
  padding: 6px 12px;
  border-radius: 5px;
  text-decoration: none;
}
.nav-link:hover {
  background: #ff7b00;
  color: #fff;
}

/* ===== HERO SECTION ===== */
.hero {
  background: url('https://static.vecteezy.com/system/resources/thumbnails/048/509/396/small/blank-white-book-cover-mock-up-on-an-italian-kitchen-table-surrounded-by-fresh-herbs-and-italian-ingredients-photo.jpg') no-repeat center center;
  background-size: cover;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
}
.hero .overlay {
  background: rgba(0,0,0,0.6);
  padding: 30px;
  border-radius: 15px;
  color: #fff;
  max-width: 800px;
}
.hero h1 {
  font-size: 2.5rem;
  margin-bottom: 15px;
}
.hero p {
  font-size: 1.1rem;
  margin-bottom: 20px;
}
.hero .btn {
  background: #ff7b00;
  color: #fff;
  padding: 10px 20px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;
}
.hero .btn:hover {
  background: #fff;
  color: #ff7b00;
}

/* ===== USER CARDS ===== */
.user-cards {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 30px;
  flex-wrap: wrap;
}
.card {
  background: rgba(255, 255, 255, 0.9);
  padding: 20px;
  border-radius: 15px;
  width: 250px;
  text-align: center;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  transition: transform 0.3s;
}
.card:hover {
  transform: scale(1.05);
}
.card h3 {
  color: #ff7b00;
}
/* ===== USER ACTION CARDS ===== */
.user-action-card {
  background: rgba(255, 255, 255, 0.9);
  padding: 20px;
  border-radius: 15px;
  width: 250px;
  text-align: center;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  transition: transform 0.3s;
  color: #000;
}
.user-action-card:hover {
  transform: scale(1.05);
}
.user-action-card h3 {
  color: #5d5757ff;
}
.user-action-card p {
  color: #000;
}

/* ===== RECENT RECIPES ===== */
.recent-recipes {
  background: #fffaf2;
  padding: 40px 20px;
  text-align: center;
}
.recent-recipes h2 {
  color: #ff7b00;
  margin-bottom: 25px;
}
.recipe-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}
.recipe-card {
  background: #fff;
  border-radius: 10px;
  width: 220px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  overflow: hidden;
}
.recipe-card img {
  width: 100%;
  height: 140px;
  object-fit: cover;
}
.recipe-card h4 {
  padding: 10px;
  color: #333;
}

/* ===== PROFILE SUMMARY ===== */
.profile-summary {
  background: #fff;
  border-radius: 15px;
  max-width: 350px;
  margin: 30px auto;
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.profile-summary h3 {
  color: #ff7b00;
}
.profile-summary p {
  margin: 5px 0;
  color: #555;
}

/* ===== NOTIFICATIONS ===== */
.notifications {
  background: #ff7b00;
  color: #fff;
  padding: 15px 20px;
  text-align: center;
}
.notifications p {
  margin: 0;
  font-weight: 500;
}

/* ===== FOOTER ===== */
footer {
  background: #ff7b00;
  color: #fff;
  text-align: center;
  padding: 15px 0;
  margin-top: 50px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .user-cards {
    flex-direction: column;
    align-items: center;
  }
  .recipe-list {
    flex-direction: column;
    align-items: center;
  }
}
</style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    </div>
    <?php if ($role === 'user'): ?>
      <a href="about.php">About</a>
      <a href="category.php">Categories</a>
      <a href="contact.php">Contact</a>
      <a href="feedback.php">Feedback</a>
      <a href="my_recipes.php">My Recipes</a>
    <?php endif; ?>
    <?php if ($role === 'admin'): ?>
        <a href="manage_categories.php">Manage Categories</a>
        <a href="view_contact.php">Manage Contact</a>
        <a href="view_feedback.php">Manage Feedback</a>
        <a href="view_recipes.php">Manage Recipes</a>
        <a href="view_users.php">Manage Users</a>
    <?php endif; ?>
  </nav>
  <div class="auth-links">
    <?php if ($role === 'admin'): ?>
      <span class="welcome">👋 Hello Admin</span>
      <a href="logout.php" class="nav-link">Logout</a>
    <?php elseif ($role === 'user'): ?>
      <a href="userprofile.php" title="Your Profile" style="
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: #fff;
        color: #ff7b00;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
      " 
      onmouseover="this.style.background='#ff7b00'; this.style.color='#fff';" 
      onmouseout="this.style.background='#fff'; this.style.color='#ff7b00';">
        👤
      </a>
      <span class="welcome">👋 Hello <?php echo htmlspecialchars($email); ?></span>
      <a href="logout.php" class="nav-link">Logout</a>
    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
      <a href="admin_login.php" class="nav-link">Admin</a>
    <?php endif; ?>
  </div>
</header>

<!-- ===== NOTIFICATIONS ===== -->
<section class="notifications">
  <p>🎉 New: Italian recipes are now live! Check them out under Categories 🍝</p>
</section>

<!-- ===== HERO SECTION ===== -->
<header class="hero">
  <div class="overlay">
    <?php if ($role === 'admin'): ?>
      <h1><?php echo $greeting; ?>, Admin 👋</h1>
      <p>Manage and organize your recipe platform efficiently!</p>
      <a href="view_recipes.php" class="btn">Go to Admin Panel</a>
    <?php elseif ($role === 'user'): ?>
      <h1><?php echo $greeting; ?>, <?php echo htmlspecialchars($email); ?>!</h1>
      <p>Explore delicious vegetarian recipes curated just for you!</p>
    <div class="user-cards">
    <a href="search_recipeS.php" class="user-action-card">
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

    <?php else: ?>
      <h1><?php echo $greeting; ?>! Welcome to Veggiedelights 🥘</h1>
      <p>Discover and share amazing vegetarian recipes!</p>
    <?php endif; ?>
  </div>
</header>

<!-- ===== PROFILE SUMMARY ===== -->
<?php if ($role === 'user'): ?>
<section class="profile-summary">
  <h3>👤 Your Profile</h3>
  <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
  <p><strong>Member Since:</strong> Jan 2025</p>
  <p><strong>Recipes Shared:</strong> 5</p>
</section>
<?php endif; ?>

<!-- ===== RECENTLY ADDED RECIPES ===== -->
<section class="recent-recipes">
  <h2>🍽️ Recently Added Recipes</h2>
  <div class="recipe-list">
    <div class="recipe-card">
      <img src="https://thumbs.dreamstime.com/b/indian-food-celebrations-dishes-like-paneer-tikka-chicken-masala-their-vibrant-colors-aromatic-spices-bring-festive-joy-329320659.jpg" alt="Paneer Tikka">
      <h4>Paneer Tikka</h4>
    </div>
    <div class="recipe-card">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_9O0Xv_3SssvA84nweLOcKix9Yf6IJH9NlQ&s" alt="Veg Lasagna">
      <h4>Veg Lasagna</h4>
    </div>
    <div class="recipe-card">
      <img src="https://static.vecteezy.com/system/resources/thumbnails/040/986/112/small/ai-generated-indian-biryani-rice-professional-advertising-foodgraphy-photo.jpg" alt="Veg Fried Rice">
      <h4>Veg Fried Rice</h4>
    </div>
    <div class="recipe-card">
      <img src="https://i.pinimg.com/736x/e8/dc/7f/e8dc7f0b59b8602ba30621dee3c6291c.jpg" alt="Masala Dosa">
      <h4>Masala Dosa</h4>
    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>

</body>
</html>
