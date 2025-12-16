<?php
session_start();
include 'config.php';

$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
$category = $_GET['cat'] ?? '';
if(!$category) die("Category not specified.");

// Fetch recipes in category
$stmt = $con->prepare("SELECT * FROM recipes WHERE category=? ORDER BY id DESC");
$stmt->bind_param("s",$category);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user favorites
$fav_ids = [];
if($email){
    $stmt2 = $con->prepare("SELECT recipe_id FROM favorites WHERE email=?");
    $stmt2->bind_param("s",$email);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    while($row2 = $res2->fetch_assoc()){
        $fav_ids[] = $row2['recipe_id'];
    }
    $stmt2->close();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($category) ?> Recipes</title>
<link rel="stylesheet" href="css/category_recipe.css">
</head>
<body>

<header class="navbar">
    <div><a href="index.php">🥘 Veggiedelights</a></div>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="category.php">Categories</a>
        <a href="contact.php">Contact</a>
        <a href="feedback.php">Feedback</a>
        <a href="my_recipes.php">My Recipes</a>
    </nav>
    <div class="auth-links">
        <?php if($email): ?>
          <a href="userprofile.php" class="profile-icon">👤</a>
            <span>👋 <?= htmlspecialchars($email); ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</header>

<a href="category.php" class="back-btn">← Back to Categories</a>
<h1 style="text-align:center; color:#FF8C00;"><?= htmlspecialchars($category) ?> Recipes</h1>

<section class="recipe-container">
<?php
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $fav_class = in_array($row['id'],$fav_ids)?'favorited':'';
        echo '<div class="recipe-card">';
        echo '<span class="heart '.$fav_class.'" data-id="'.$row['id'].'">♥</span>';
        echo '<img src="'.htmlspecialchars($row['image']).'">';
        echo '<h2>'.htmlspecialchars($row['name']).'</h2>';
        echo '<p class="description">'.htmlspecialchars($row['description']).'</p>';
        echo '<div class="card-content">';
        echo '<p><strong>Ingredients:</strong><br>';
        foreach(explode("\n",$row['ingredients']) as $ing){ if(trim($ing)!=='') echo htmlspecialchars($ing).'<br>'; }
        echo '</p><p><strong>Steps:</strong><br>';
        foreach(explode("\n",$row['steps']) as $step){ if(trim($step)!=='') echo htmlspecialchars($step).'<br>'; }
        echo '</p></div>';
        echo '</div>';
    }
}else{
    echo "<p style='text-align:center;'>No recipes found.</p>";
}
?>
</section>

<footer>
    &copy; 2025 Veggiedelights | All Rights Reserved
</footer>

<script src="js/category_recipes.js"></script>

</body>
</html>
