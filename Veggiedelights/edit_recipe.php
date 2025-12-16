<?php
session_start();
include "config.php";

// Get user role and email from session
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';

// Get recipe ID from URL
$recipe_id = $_GET['recipe_id'] ?? 0;
$recipe_id = intval($recipe_id);

if (!$recipe_id) {
    die("Invalid recipe ID.");
}

// Fetch recipe details
$stmt = $con->prepare("SELECT * FROM recipes WHERE id=?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe) {
    die("Recipe not found.");
}

// Permission check
if ($role !== 'admin' && $recipe['user_email'] !== $email) {
    die("You do not have permission to edit this recipe.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? ''; // NEW
    $ingredients = $_POST['ingredients'] ?? '';
    $steps = $_POST['steps'] ?? '';
    $imagePath = $_POST['image_url'] ?? $recipe['image']; // Use URL instead of upload

    // Update recipe
    $update = $con->prepare("UPDATE recipes 
        SET name=?, category=?, description=?, ingredients=?, steps=?, image=? 
        WHERE id=?");
    $update->bind_param("ssssssi", $name, $category, $description, $ingredients, $steps, $imagePath, $recipe_id);

    if ($update->execute()) {
        header("Location: view_recipes.php");
        exit;
    } else {
        $error = "Failed to update recipe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Recipe | Veggiedelights</title>
<style>
body { font-family: Arial, sans-serif; background:#f0f0f0; margin:0; padding:20px; }
form { max-width:600px; margin:0 auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
form h2 { text-align:center; color:#ff7b00; }
form label { display:block; margin-top:10px; font-weight:bold; }
form input[type=text], form textarea, form select {
    width:100%; padding:8px; margin-top:5px; border-radius:5px; border:1px solid #ccc;
}
form textarea { resize:vertical; min-height:100px; }
form button {
    margin-top:15px; padding:10px 15px; background:#28a745; color:#fff;
    border:none; border-radius:5px; cursor:pointer; font-weight:bold;
}
form button:hover { background:#218838; }
.error { color:red; text-align:center; margin-bottom:10px; }
.current-image { margin-top:10px; text-align:center; }
.current-image img { width:100%; max-height:250px; object-fit:cover; border-radius:6px; margin-top:5px; }
</style>
</head>
<body>

<form method="POST">
    <h2>Edit Recipe</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <label for="name">Recipe Name:</label>
    <input type="text" name="name" id="name" 
           value="<?= htmlspecialchars($recipe['name']) ?>" required>

    <label for="category">Category:</label>
    <select name="category" id="category" required>
        <option value="North Indian" <?= $recipe['category']=='North Indian'?'selected':'' ?>>North Indian</option>
        <option value="South Indian" <?= $recipe['category']=='South Indian'?'selected':'' ?>>South Indian</option>
        <option value="Chinese" <?= $recipe['category']=='Chinese'?'selected':'' ?>>Chinese</option>
        <option value="Italian" <?= $recipe['category']=='Italian'?'selected':'' ?>>Italian</option>
    </select>

    <!-- NEW DESCRIPTION FIELD -->
    <label for="description">Short Description:</label>
    <textarea name="description" id="description" required><?= htmlspecialchars($recipe['description']) ?></textarea>

    <label for="ingredients">Ingredients (comma separated):</label>
    <textarea name="ingredients" id="ingredients" required><?= htmlspecialchars($recipe['ingredients']) ?></textarea>

    <label for="steps">Steps:</label>
    <textarea name="steps" id="steps" required><?= htmlspecialchars($recipe['steps']) ?></textarea>

    <label for="image_url">Recipe Image URL:</label>
    <input type="text" name="image_url" id="image_url"
           value="<?= htmlspecialchars($recipe['image']) ?>" required>

    <?php if (!empty($recipe['image'])): ?>
        <div class="current-image">
            <strong>Current Image Preview:</strong>
            <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="Recipe Image">
        </div>
    <?php endif; ?>

    <button type="submit">Update Recipe</button>
</form>

</body>
</html>
