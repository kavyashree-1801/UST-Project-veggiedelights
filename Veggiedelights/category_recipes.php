<?php
session_start();
include 'config.php'; // Make sure $con is a valid mysqli connection

$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';

$category = $_GET['cat'] ?? '';
if (!$category) { die("Category not specified."); }

// Fetch recipes in this category
$stmt = $con->prepare("SELECT * FROM recipes WHERE category=? ORDER BY id DESC");
if(!$stmt){
    die("Prepare failed: ".$con->error);
}
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user favorites if logged in
$fav_ids = [];
if($email){
    $stmt2 = $con->prepare("SELECT recipe_id FROM favorites WHERE email=?");
    if(!$stmt2){
        die("Prepare failed: ".$con->error);
    }
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    while($row2 = $res2->fetch_assoc()){
        $fav_ids[] = $row2['recipe_id'];
    }
    $stmt2->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($category) ?> Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/styles.css">
<style>
/* ===== Navbar ===== */
header.navbar {
  display: flex; justify-content: space-between; align-items: center;
  padding: 15px 30px; background: #FF8C00; color: #fff; flex-wrap: wrap;
  border-radius: 0 0 10px 10px;
}
header.navbar .logo a { font-size: 1.5rem; font-weight: bold; color: #fff; text-decoration: none; }
header.navbar nav { display: flex; gap: 15px; flex-wrap: wrap; }
header.navbar nav a { color: #fff; text-decoration: none; padding: 8px 12px; border-radius: 6px; font-weight: bold; transition: all 0.3s; }
header.navbar nav a:hover { background: #fff; color: #FF8C00; }
.dropdown { position: relative; }
.dropdown-content { display: none; position: absolute; background: #ff7b00; color: #fff; min-width: 150px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border-radius: 6px; overflow: hidden; top: 30px; z-index: 100; }
.dropdown-content a { display: block; padding: 10px 12px; color: #fff; transition: all 0.3s; }
.dropdown-content a:hover { background: #fff; color: #ff7b00; }
.dropdown:hover .dropdown-content { display: block; }
.auth-links { display: flex; align-items: center; gap: 10px; }
.auth-links a { color: #FF8C00; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-weight: bold; transition: all 0.3s; }
.auth-links a:hover { background: #fff; color: #FF8C00; }
#themeToggle { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #fff; transition: all 0.3s; }
#themeToggle:hover { color: #333; }

/* ===== Back Button ===== */
.back-btn { display:block; width:max-content; margin:20px auto 10px; padding:10px 20px; background:#FF8C00; color:#fff; text-decoration:none; border-radius:6px; font-weight:bold; transition:0.3s; }
.back-btn:hover { background:#fff; color:#FF8C00; }

/* ===== Recipe Cards ===== */
.recipe-container { display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:20px; padding:20px; }
.recipe-card { background:#f9f9f9; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center; padding:15px; position:relative; cursor:pointer; transition:all 0.3s; }
.recipe-card img { width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:10px; }
.recipe-card h2 { margin:0 0 10px; color:#333; font-size:1.2rem; }
.recipe-card p.description { font-size:0.95rem; color:#555; margin-bottom:10px; }

/* Heart Icon */
.heart { font-size: 24px; color:#ccc; position:absolute; top:12px; right:12px; cursor:pointer; transition:color 0.3s; z-index:10; }
.heart.favorited { color:#e74c3c; }

/* Collapsible content */
.card-content { display:none; text-align:left; max-height:300px; overflow-y:auto; padding-top:10px; }
.card-content.show { display:block; }
.ingredients-list, .steps { font-size:0.9rem; line-height:1.4; margin-bottom:10px; }
.card-content::-webkit-scrollbar { display:none; }
</style>
</head>
<body>
<header class="navbar">
  <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>
  <div class="auth-links">
    <?php if($role==='admin'): ?>
      <span class="welcome">👋 Hello Admin</span>
      <a href="logout.php">Logout</a>
    <?php elseif($role==='user'): ?>
      <a href="userprofile.php">👤</a>
      <span class="welcome">👋 <?= htmlspecialchars($email); ?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="admin_login.php">Admin</a>
    <?php endif; ?>
  </div>
</header>

<a href="category.php" class="back-btn">← Back to Categories</a>
<h1 style="text-align:center; color:#FF8C00;"><?= htmlspecialchars($category) ?> Recipes</h1>

<section class="recipe-container">
<?php
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $is_fav = in_array($row['id'],$fav_ids)?'favorited':'';
        echo '<div class="recipe-card">';
        echo '<span class="heart '.$is_fav.'" data-id="'.$row['id'].'">♥</span>';
        echo '<img src="'.htmlspecialchars($row['image']).'">';
        echo '<h2>'.htmlspecialchars($row['name']).'</h2>';
        echo '<p class="description">'.htmlspecialchars($row['description']).'</p>';
        echo '<div class="card-content">';
        echo '<p><strong>Ingredients:</strong></p><div class="ingredients-list">';
        foreach(explode("\n",$row['ingredients']) as $ing){ if(trim($ing)!=='') echo htmlspecialchars($ing).'<br>'; }
        echo '</div><p><strong>Steps:</strong></p><div class="steps">';
        foreach(explode("\n",$row['steps']) as $step){ if(trim($step)!=='') echo htmlspecialchars($step).'<br>'; }
        echo '</div></div></div>';
    }
}else{
    echo "<p style='text-align:center;color:#555;'>No recipes found.</p>";
}
$stmt->close();
?>
</section>

<script>
// Toggle favorite
document.querySelectorAll('.heart').forEach(heart=>{
  heart.addEventListener('click', e=>{
    e.stopPropagation();
    const recipeId = heart.dataset.id;
    fetch('toggle_favorite.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:'recipe_id='+recipeId
    })
    .then(res=>res.text())
    .then(res=>{
      if(res==='added'){ heart.classList.add('favorited'); }
      else if(res==='removed'){ heart.classList.remove('favorited'); }
      else{ alert(res); }
    });
  });
});

// Expand card to show ingredients & steps
document.querySelectorAll('.recipe-card').forEach(card=>{
  card.addEventListener('click', ()=>{
    const content = card.querySelector('.card-content');
    content.classList.toggle('show');
  });
});
</script>
</body>
</html>
