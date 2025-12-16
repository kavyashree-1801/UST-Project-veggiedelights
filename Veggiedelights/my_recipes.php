<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/myrecipes.css">
</head>
<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>
  <div class="auth-links">
    <a href="userprofile.php" class="profile-icon">👤</a>
    <span class="welcome">👋 Hello <?=htmlspecialchars($_SESSION['email'])?></span>
    <a href="logout.php" class="nav-link-logout">Logout</a>
  </div>
</header>

<h1>My Recipes</h1>

<div class="recipe-container" id="recipeContainer">
    <p>Loading recipes...</p>
</div>

<footer class="footer">
    © 2025 Veggiedelights | All Rights Reserved 🍽️
</footer>

<script>
// Fetch recipes
async function loadRecipes() {
    const container = document.getElementById('recipeContainer');
    container.innerHTML = '<p>Loading recipes...</p>';

    try {
        const res = await fetch('api/my_recipe.php');
        const data = await res.json();

        if (!data.success) {
            container.innerHTML = `<p style="color:red;">${data.error}</p>`;
            return;
        }

        if (data.recipes.length === 0) {
            container.innerHTML = '<p>No recipes added yet. 🍽️</p>';
            return;
        }

        container.innerHTML = '';
        data.recipes.forEach(recipe => {
            const card = document.createElement('div');
            card.className = 'recipe-card';

            // Convert ingredients and steps to <li>
            const ingredientList = recipe.ingredients.split(/,|\n/).map(i => `<li>${i.trim()}</li>`).join('');
            const stepList = recipe.steps.split(/\n/).map(s => `<li>${s.trim()}</li>`).join('');

            card.innerHTML = `
                <img src="${recipe.image}" alt="${recipe.name}" onerror="this.src='images/default.png'">
                <h2>${recipe.name}</h2>
                <p>${recipe.description.substring(0, 120)}...</p>
                <button class="delete-btn" onclick="deleteRecipe(event, ${recipe.id})">Delete</button>
                <div class="expanded-content">
                    <h3>Ingredients:</h3>
                    <ul class="no-bullets">${ingredientList}</ul>
                    <h3>Steps:</h3>
                    <ul class="no-bullets">${stepList}</ul>
                </div>
            `;

            // Toggle expand/collapse on card click
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-btn')) return;
                card.classList.toggle('expanded');
            });

            container.appendChild(card);
        });
    } catch (err) {
        container.innerHTML = `<p style="color:red;">Server error!</p>`;
        console.error(err);
    }
}

// Delete recipe
async function deleteRecipe(event, id) {
    event.stopPropagation();
    if (!confirm('Are you sure you want to delete this recipe?')) return;

    const formData = new FormData();
    formData.append('id', id);

    try {
        const res = await fetch('delete_recipe.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            alert('Recipe deleted successfully!');
            loadRecipes();
        } else {
            alert('Error: ' + data.error);
        }
    } catch (err) {
        alert('Server error!');
        console.error(err);
    }
}

// Load recipes on page load
loadRecipes();
</script>

</body>
</html>
