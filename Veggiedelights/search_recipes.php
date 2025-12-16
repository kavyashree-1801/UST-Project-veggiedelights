<?php
session_start();
$email = $_SESSION['email'] ?? '';
$role = $_SESSION['role'] ?? 'guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/search.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <?php if($role === 'user'): ?>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
    <?php endif; ?>
  </nav>
  <div class="auth-links">
    <?php if($role === 'user'): ?>
      <a href="userprofile.php" class="profile-icon">👤</a>
      <span class="welcome">👋 <?= htmlspecialchars($email) ?></span>
      <form action="logout.php" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
    <?php endif; ?>
  </div>
</header>

<main>
<h1>Search Recipes</h1>

<div class="search-form">
    <input type="text" id="searchInput" placeholder="Enter recipe name">
    <button onclick="searchRecipes()">Search</button>
</div>

<div class="recipe-container" id="recipeContainer">
    <p style="text-align:center;">Loading recipes...</p>
</div>
</main>

<footer>
  © 2025 Veggiedelights | All rights reserved
</footer>

<script>
async function loadRecipes(query=''){
    const container = document.getElementById('recipeContainer');
    container.innerHTML = '<p style="text-align:center;">Loading recipes...</p>';

    const res = await fetch(`api/search_recipe.php?q=${encodeURIComponent(query)}`);
    const data = await res.json();

    if(!data.success){
        container.innerHTML = `<p style="color:red;">${data.error || 'Error loading recipes'}</p>`;
        return;
    }

    if(data.recipes.length === 0){
        container.innerHTML = `<p style="text-align:center;">No recipes found.</p>`;
        return;
    }

    container.innerHTML = '';
    data.recipes.forEach(recipe=>{
        const card = document.createElement('div');
        card.className = 'recipe-card';
        card.innerHTML = `
            <img src="${recipe.image || 'placeholder.png'}" alt="${recipe.name}">
            <h2>${recipe.name}</h2>
            <p>${recipe.description}</p>

            <div class="recipe-details">
                <h3>Ingredients:</h3>
                ${recipe.ingredients.split('\n').map(i => `<p>${i}</p>`).join('')}

                <h3>Steps:</h3>
                ${recipe.steps.split('\n').map(s => `<p>${s}</p>`).join('')}
            </div>
        `;
        container.appendChild(card);

        // Toggle recipe details on click
        card.addEventListener('click', ()=>{
            const details = card.querySelector('.recipe-details');
            details.style.display = (details.style.display === 'block') ? 'none' : 'block';
        });
    });
}

function searchRecipes(){
    const query = document.getElementById('searchInput').value;
    loadRecipes(query);
}

// Load all recipes initially
loadRecipes();
</script>
</body>
</html>
