<?php
session_start();
include 'config.php';

// Default role and email
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';

// Redirect non-admin users
if ($role !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle form submission
$success = $error = '';
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $imagePath = '';

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/categories/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            $error = "❌ Failed to upload image.";
        }
    }

    if (!$error) {
        mysqli_query($con, "INSERT INTO categories (name, image) VALUES ('$name', '$imagePath')");
        $success = "✅ Category added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Category | Veggiedelights</title>
<style>
body {
  font-family: "Poppins", sans-serif;
  background: #f8f8f8;
  margin: 0;
  padding: 0;
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
  background-color: #ff7b00; /* 🔸 Orange background */
  min-width: 180px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  border-radius: 8px;
  flex-direction: column;
  z-index: 10;
}
.dropdown-content a {
  color: #fff; /* White text */
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

/* ===== MAIN CONTENT ===== */
.main-content {
  max-width: 500px;
  margin: 50px auto;
  padding: 30px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
h2 {
  text-align: center;
  color: #333;
}

/* ===== FORM ===== */
form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
form label {
  font-weight: bold;
}
form input[type="text"],
form input[type="file"] {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
form button {
  padding: 12px;
  background: #ff7b00;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
  transition: 0.3s;
}
form button:hover {
  opacity: 0.9;
}

/* Messages */
.success {
  color: green;
  font-weight: bold;
  text-align: center;
}
.error {
  color: red;
  font-weight: bold;
  text-align: center;
}

/* Back link */
.back {
  display: inline-block;
  margin-top: 15px;
  text-decoration: none;
  color: #ff7b00;
  font-weight: bold;
}
.back:hover {
  text-decoration: underline;
}
</style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
  
  <nav>
        <a href="index.php">Home</a>
        <a href="view_users.php">Manage Users</a>
        <a href="view_recipes.php">Manage Recipes</a>
        <a href="manage_categories.php">Manage Categories</a>
        <a href="view_feedback.php">Manage Feedback</a>
        <a href="view_contacts.php">Manage Contacts</a>
  </nav>

  <div class="auth-links">
    <span class="welcome">👋 Hello Admin</span>
    <a href="logout.php" class="nav-link">Logout</a>
  </div>
</header>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">
  <h2>Add New Category</h2>

  <?php if ($success) echo "<p class='success'>$success</p>"; ?>
  <?php if ($error) echo "<p class='error'>$error</p>"; ?>

  <form method="POST" enctype="multipart/form-data">
    <div>
      <label for="name">Category Name:</label>
      <input type="text" id="name" name="name" required>
    </div>

    <div>
      <label for="image">Category Image (optional):</label>
      <input type="file" id="image" name="image" accept="image/*">
    </div>

    <button type="submit" name="submit">Add Category</button>
  </form>

  <a href="manage_categories.php" class="back">← Back to Categories</a>
</div>

</body>
</html>
