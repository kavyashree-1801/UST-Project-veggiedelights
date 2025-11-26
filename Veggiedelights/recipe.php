<?php
session_start();
include "config.php";

// Redirect if not logged in
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION["email"];

// Validate recipe ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid recipe.");
}

$recipe_id = intval($_GET["id"]);

// ✅ Correct table name + error debugging
$query = "SELECT * FROM recipes WHERE id = ? AND email = ?";
$stmt = $con->prepare($query);

if (!$stmt) {
    die("SQL ERROR: " . $con->error);
}

$stmt->bind_param("is", $recipe_id, $email);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe) {
    die("Recipe not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($recipe["name"]); ?> | Veggiedelights</title>
  <style>
    body { font-family: Arial, sans-serif; background: #fff7f7; margin: 0; padding: 0; color: #333; }
    .container { max-width: 800px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    img { width: 100%; border-radius: 10px; margin-bottom: 20px; }
    h1 { text-align: center; color: #e64a19; }
    h2 { color: #555; margin-top: 20px; }
    ul, ol { line-height: 1.7; }
    a.back { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #ff7b00; color: #fff; text-decoration: none; border-radius: 6px; }
    a.back:hover { background: #ff7b00; }
  </style>
</head>
<body>
  <div class="container">
    <h1><?php echo htmlspecialchars($recipe["name"]); ?></h1>
    <img src="<?php echo htmlspecialchars($recipe["image"]); ?>" alt="<?php echo htmlspecialchars($recipe["name"]); ?>">

    <p><?php echo nl2br(htmlspecialchars($recipe["description"])); ?></p>

    <h2>Ingredients</h2>
    <ul>
      <?php
      $ingredients = explode("\n", $recipe["ingredients"]);
      foreach ($ingredients as $ing) {
          if(trim($ing) !== ""){
              echo '<li>' . htmlspecialchars($ing) . '</li>';
          }
      }
      ?>
    </ul>

    <h2>Instructions</h2>
    <ol>
      <?php
      $steps = explode("\n", $recipe["steps"]);
      foreach ($steps as $step) {
          $step = preg_replace('/^\d+\.\s*/', '', $step);
          if(trim($step) !== ""){
              echo '<li>' . htmlspecialchars($step) . '</li>';
          }
      }
      ?>
    </ol>

    <a href="my_recipes.php" class="back">← Back to My Recipes</a>
  </div>
</body>
</html>
