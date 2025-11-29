<?php
session_start();
include "config.php";

// Get user role and email from session
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';

// Get selected category from dropdown or URL
$category = $_GET['category'] ?? '';

// Build query
if ($category && $category !== 'All') {
    $stmt = $con->prepare("SELECT * FROM recipes WHERE category=? ORDER BY id DESC");
    $stmt->bind_param("s", $category);
} else {
    $stmt = $con->prepare("SELECT * FROM recipes ORDER BY id DESC");
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Recipes | Veggiedelights</title>

<style>
body { 
    font-family: Arial, sans-serif; 
    background: #f0f0f0; 
    margin:0; 
    padding-top: 100px; 
}

/* ==================== NAVBAR ==================== */
header.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #ff7b00;
    padding: 12px 30px;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: normal;
    flex-wrap: nowrap; /* no wrapping */
    gap: 10px;
}

/* Logo */
header.navbar .logo a {
    color: #fff;
    font-size: 1.6rem;
    font-weight: bold;
    text-decoration: none;
    white-space: nowrap;
}

/* Navbar links */
.nav-links {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-shrink: 1; /* allows shrinking on small screens */
    overflow-x: auto;
}

.nav-links a {
    color: #fff;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.3s;
    white-space: nowrap;
}

.nav-links a:hover,
.nav-links a.active {
    background: #fff;
    color: #ff7b00;
}

/* Auth links always visible on right */
.auth-links {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0; /* prevent shrinking */
    white-space: nowrap;
}

.auth-links span {
    color: #fff;
    font-weight: bold;
}

.auth-links .nav-link {
    background: #fff;
    color: #ff7b00;
    padding: 6px 12px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
}

.auth-links .nav-link:hover {
    background: #ff7b00;
    color: #fff;
}

/* ==================== RECIPE CARDS ==================== */
.recipe-container {
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
    margin:20px;
}

.recipe-card {
    background:#fff;
    padding:15px;
    border-radius:10px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
    width:300px;
    height:480px;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.recipe-card img {
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:6px;
    margin-bottom:10px;
}

.recipe-card h2 { margin:5px 0; color:#333; }
.recipe-card p { margin:5px 0; color:#555; font-size:0.9rem; }

.recipe-card .steps {
    white-space: pre-line;
    font-size:0.9rem;
    color:#555;
    max-height:90px;
    overflow-y:auto;
    margin-top:5px;
}

.added-by {
    font-style:italic;
    color:#777;
    margin-top:auto;
}

.card-actions {
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-top:10px;
}

.edit-btn, .delete-btn {
    flex:1;
    padding:8px;
    border:none;
    border-radius:5px;
    color:#fff;
    cursor:pointer;
    font-weight:bold;
}

.edit-btn { background:#007bff; }
.edit-btn:hover { background:#0069d9; }

.delete-btn { background:#dc3545; }
.delete-btn:hover { background:#c82333; }

#categorySelect { padding:8px 12px; border-radius:6px; border:1px solid #ccc; margin:20px; }
h1 { text-align:center; margin-top:20px; color:#ff7b00; }

/* Responsive fix: make nav-links scrollable */
@media (max-width: 768px) {
    header.navbar {
        flex-wrap: wrap;
    }
    .nav-links {
        flex-basis: 100%;
        overflow-x: auto;
        margin-bottom: 8px;
    }
}
</style>
</head>

<body>

<header class="navbar">
    <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <?php if ($role === 'user'): ?>
            <a href="about.php">About</a>
            <a href="category.php">Categories</a>
            <a href="contact.php">Contact</a>
            <a href="feedback.php">Feedback</a>
            <a href="my_recipes.php">My Recipes</a>
        <?php elseif ($role === 'admin'): ?>
            <a href="manage_categories.php">Manage Categories</a>
            <a href="view_contact.php">Manage Contact</a>
            <a href="view_feedback.php">Manage Feedback</a>
            <a href="view_recipes.php" class="active">Manage Recipes</a>
            <a href="view_users.php">Manage Users</a>
        <?php endif; ?>
    </div>

    <div class="auth-links">
        <?php if ($role === 'admin'): ?>
            <span>👋 Hello Admin</span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php elseif ($role === 'user'): ?>
            <span>👋 Hello <?= htmlspecialchars($email) ?></span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
        <?php endif; ?>
    </div>
</header>

<h1><?= $category ? htmlspecialchars($category) : 'All' ?> Recipes</h1>

<form method="GET" style="text-align:center;">
    <select name="category" id="categorySelect" onchange="this.form.submit()">
        <option value="All">All Categories</option>
        <option value="North Indian" <?= $category=='North Indian'?'selected':'' ?>>North Indian</option>
        <option value="South Indian" <?= $category=='South Indian'?'selected':'' ?>>South Indian</option>
        <option value="Chinese" <?= $category=='Chinese'?'selected':'' ?>>Chinese</option>
        <option value="Italian" <?= $category=='Italian'?'selected':'' ?>>Italian</option>
    </select>
</form>

<div class="recipe-container">
<?php
if ($result->num_rows == 0) {
    echo "<p style='text-align:center;color:#444;'>No recipes found.</p>";
}

while ($row = $result->fetch_assoc()) {
    echo '<div class="recipe-card">';
    echo '<img src="'.(!empty($row['image'])?htmlspecialchars($row['image']):'uploads/default.png').'" alt="Recipe Image">';
    echo '<h2>'.htmlspecialchars($row['name']).'</h2>';
    echo '<p><strong>Category:</strong> '.htmlspecialchars($row['category']).'</p>';
    echo '<p><strong>Ingredients:</strong> '.htmlspecialchars($row['ingredients']).'</p>';
    echo '<p><strong>Steps:</strong></p>';
    echo '<div class="steps">'.htmlspecialchars($row['steps']).'</div>';
    if (!empty($row['user_email'])) {
        echo '<p class="added-by">Added by: '.htmlspecialchars($row['user_email']).'</p>';
    }
    if ($role==='admin' || ($role==='user' && $email==$row['user_email'])) {
        echo '<div class="card-actions">';
        echo '<form method="get" action="edit_recipe.php">';
        echo '<input type="hidden" name="recipe_id" value="'.htmlspecialchars($row['id']).'">';
        echo '<button type="submit" class="edit-btn">Edit</button></form>';
        echo '<form method="post" action="delete_recipe.php" onsubmit="return confirm(\'Are you sure?\');">';
        echo '<input type="hidden" name="recipe_id" value="'.htmlspecialchars($row['id']).'">';
        echo '<button type="submit" class="delete-btn">Delete</button></form>';
        echo '</div>';
    }
    echo '</div>';
}
$stmt->close();
?>
</div>

</body>
</html>
