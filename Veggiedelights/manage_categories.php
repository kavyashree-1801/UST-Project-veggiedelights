<?php
session_start();
include 'config.php';

// Fetch role and email from session
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';

// Fetch dynamic categories from the database
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recipe Categories | Veggiedelights</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      margin: 0;
      background: #f8f8f8;
    }

    /* ===== NAVBAR ===== */
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
      font-weight:bold;
    }

    header.navbar nav a:hover {
      background: #fff;
      color: #ff7b00;
    }

    /* ===== DROPDOWN ===== */
    .dropdown {
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 38px;
      left: 0;
      background-color: #ff7b00; /* Orange dropdown */
      min-width: 180px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      border-radius: 8px;
      flex-direction: column;
      z-index: 10;
    }

    .dropdown-content a {
      color: #fff;
      padding: 10px 15px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dropdown-content a:last-child {
      border-bottom: none;
    }

    .dropdown-content a:hover {
      background: #fff;
      color: #ff7b00;
    }

    .dropdown:hover .dropdown-content {
      display: flex;
    }

    /* ===== AUTH LINKS ===== */
    .auth-links {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .auth-links .welcome {
      color: #fff;
      font-weight: bold;
    }

    .auth-links .nav-link {
      background: #fff;
      color: #ff7b00;
      padding: 6px 12px;
      border-radius: 5px;
      text-decoration: none;
      transition: 0.3s;
    }

    .auth-links .nav-link:hover {
      background: #ff7b00;
      color: #fff;
    }

    /* ===== CATEGORY CARDS ===== */
    .category-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin: 30px 10px;
    }

    .category-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 250px;
      text-align: center;
      position: relative;
    }

    .category-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .category-card h2 {
      margin: 15px 0 10px 0;
      font-size: 1.2rem;
    }

    .category-card .btn {
      display: inline-block;
      margin-bottom: 15px;
      padding: 8px 15px;
      background: #ff7b00;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .category-card .btn:hover {
      opacity: 0.8;
    }

    /* Add Category button */
    .add-category {
      display: inline-block;
      margin: 30px auto;
      padding: 10px 20px;
      background: #28a745;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      text-align: center;
      transition: 0.3s;
    }

    .add-category:hover {
      opacity: 0.9;
    }

    .back-btn {
      display: block;
      text-align: center;
      margin: 30px auto;
      color: #ff7b00;
      text-decoration: none;
      font-weight: bold;
    }

    .back-btn:hover {
      text-decoration: underline;
    }

    footer {
      background: #ff7b00;
      color: #fff;
      text-align: center;
      padding: 15px 0;
      margin-top: 50px;
    }
  </style>
</head>
<body>

<!-- 🌐 Navbar -->
<header class="navbar">
  <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>

  <nav>
    <a href="index.php">Home</a>
   <?php if ($role === 'admin'): ?>
        <a href="manage_categories.php" class="active">Manage Categories</a>
        <a href="view_contact.php">Manage Contacts</a>
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
      <span class="welcome">👋 Hello <?php echo htmlspecialchars($email); ?></span>
      <a href="logout.php" class="nav-link">Logout</a>
    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
      <a href="admin_login.php" class="nav-link">Admin</a>
    <?php endif; ?>
  </div>
</header>

<!-- 🌸 Page Header -->
<section class="page-header" style="text-align:center; margin-top:40px;">
  <h1>Recipe Categories</h1>
  <p>Explore mouthwatering recipes from different cuisines!</p>
</section>
<!-- 🆕 Dynamic Category Cards from Database -->
<section class="category-container">
  <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
    <div class="category-card">
      <img src="<?php echo $cat['image'] ? htmlspecialchars($cat['image']) : 'uploads/default.jpg'; ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>">
      <h2><?php echo htmlspecialchars($cat['name']); ?></h2>
      <a href="italian.php" class="btn">View Recipes</a>
    </div>
  <?php endwhile; ?>
</section>

<!-- ➕ Add Category (Admin Only) -->
<?php if ($role === 'admin'): ?>
<div style="text-align:center;">
  <a href="add_category.php" class="add-category">➕ Add Category</a>
</div>
<?php endif; ?>

<!-- 🔙 Back Button -->
<a href="index.php" class="back-btn">← Back to Home</a>

<!-- 👣 Footer -->
<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>

</body>
</html>
