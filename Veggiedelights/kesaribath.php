<?php
session_start();
include "config.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$id = 25;
$email = $_SESSION["email"];

$stmt = $con->prepare("SELECT * FROM recipes WHERE id = ? AND email = ?");
$stmt->bind_param("is", $id, $email);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($recipe["name"]); ?> | Veggiedelights</title>
<link rel="stylesheet" href="css/myrecipes.css" />
</head>
<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="my_recipes.php" class="active">My Recipes</a>
  </nav>
</header>

<main>
<section class="recipe-page">
  <h1><?php echo htmlspecialchars($recipe["name"]); ?></h1>
  <img src="<?php echo htmlspecialchars($recipe["image"]); ?>" style="width:100%;max-width:500px;border-radius:10px;display:block;margin:auto;">
  <p style="text-align:center;font-weight:bold;"><?php echo nl2br(htmlspecialchars($recipe["description"])); ?></p>
  <h2>Category</h2>
  <p><?php echo htmlspecialchars($recipe["category"]); ?></p>
  <h2>Ingredients</h2>
  <p><?php echo nl2br(htmlspecialchars($recipe["ingredients"])); ?></p>
  <h2>Steps</h2>
  <p><?php echo nl2br(htmlspecialchars($recipe["steps"])); ?></p>
  <a href="my_recipes.php">⬅ Back to My Recipes</a>
</section>
</main>

<footer>
  <p>Made with ❤️ by You | © 2025 Veggiedelights</p>
</footer>

</body>
</html>