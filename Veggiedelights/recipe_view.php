<?php
session_start();
include 'config.php'; // DB connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='text-align:center; color:red;'>No recipe selected. <a href='category.php'>Go back to categories</a></p>");
}

$id = intval($_GET['id']);

// Fetch recipe details
$stmt = $con->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    die("<p style='text-align:center; color:red;'>Recipe not found. <a href='category.php'>Go back to categories</a></p>");
}

$recipe = $result->fetch_assoc();

// Split steps into array, one step per <li>
$steps = preg_split('/\d+\.\s*/', $recipe['steps'] ?? '');
$steps = array_filter($steps, fn($s) => trim($s) != ''); // Remove empty entries
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($recipe['name']); ?> | Veggiedelights</title>
<style>
body { font-family: Arial, sans-serif; background:#f8f8f8; margin:0; padding:0; }
.container { max-width: 900px; margin: 40px auto; background:#fff; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:20px; }
h1 { text-align:center; color:#333; margin-bottom:20px; }
img { width:100%; max-height:400px; object-fit:cover; border-radius:10px; margin-bottom:20px; }
h2 { color:#ff7b00; margin-top:20px; }
p, li { color:#555; font-size:1rem; line-height:1.6; }
ul, ol { margin-left:20px; }
.back-btn { display:block; text-align:center; margin:30px auto; color:#ff7b00; text-decoration:none; font-weight:bold; }
.back-btn:hover { text-decoration:underline; }
</style>
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($recipe['name']); ?></h1>
    <img src="<?php echo htmlspecialchars($recipe['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>">

    <h2>Description</h2>
    <p><?php echo htmlspecialchars($recipe['description']); ?></p>

    <h2>Ingredients</h2>
    <ul>
        <?php 
        $ingredients = explode("\n", $recipe['ingredients'] ?? '');
        foreach($ingredients as $ing) {
            if(trim($ing) != '') echo '<li>'.htmlspecialchars($ing).'</li>';
        }
        ?>
    </ul>

    <h2>Preparation Steps</h2>
    <ol>
        <?php 
        foreach($steps as $step) {
            echo '<li>'.htmlspecialchars(trim($step)).'</li>';
        }
        ?>
    </ol>

    <h2>Submitted By</h2>
    <p><?php echo htmlspecialchars($recipe['email']); ?></p>

</div>

<a href="category_recipes.php?cat=<?php echo urlencode($recipe['category']); ?>" class="back-btn">← Back to <?php echo htmlspecialchars($recipe['category']); ?> Recipes</a>

</body>
</html>
