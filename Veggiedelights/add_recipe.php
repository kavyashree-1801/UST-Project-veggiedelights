<?php
session_start();
include 'config.php';

$email = $_SESSION['email'] ?? '';
$role = $_SESSION['role'] ?? 'guest';

// Redirect if not logged in
if(!$email){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Recipe | Veggiedelights</title>
<link rel="stylesheet" href="css/add_recipe.css">
<style>
    input, textarea, select { width: 100%; padding: 10px; margin: 8px 0; border-radius: 8px; border: 1px solid #ccc; }
    button { padding: 12px; background: #ff7b00; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
    button:hover { background: #e05500; }
    .error-msg { color: red; font-weight: bold; margin-bottom: 10px; }
    .success-msg { color: green; font-weight: bold; margin-bottom: 10px; }
</style>
</head>
<body>

<header class="navbar">
    <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
    <nav class="nav-center">
        <a href="index.php">Home</a>
        <a href="category.php">Categories</a>
        <a href="contact.php">Contact</a>
        <a href="feedback.php">Feedback</a>
        <a href="my_recipes.php">My Recipes</a>
    </nav>
    <div class="auth-links">
        <a href="userprofile.php" class="profile-icon">👤</a>
        <span class="welcome">👋 <?= htmlspecialchars($email); ?></span>
        <a href="logout.php">Logout</a>
    </div>
</header>

<h1>Add Your Recipe</h1>
<div id="msg"></div>

<form id="recipeForm">
    <input type="text" name="name" placeholder="Recipe Name" required>
    <textarea name="description" placeholder="Short Description" required></textarea>
    <textarea name="ingredients" placeholder="Ingredients (separated by commas)" required></textarea>
    <textarea name="steps" placeholder="Steps (numbered like 1. Step 2. Step)" required></textarea>
    <input type="text" name="image" placeholder="Image URL" required>
    <select name="category" required>
      <option value="">Select Category</option>
      <option value="North Indian">North Indian</option>
      <option value="South Indian">South Indian</option>
      <option value="Chinese">Chinese</option>
      <option value="Italian">Italian</option>
    </select>
    <button type="submit">✅ Save Recipe</button>
</form>

<footer>
    © 2025 Veggiedelights | All rights reserved
</footer>

<script src="js/add_recipe.js"></script>

</body>
</html>
