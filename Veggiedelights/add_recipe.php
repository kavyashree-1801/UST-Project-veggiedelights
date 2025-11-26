<?php
session_start();
include 'config.php';

// Redirect if not logged in
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$role = $_SESSION['role']; 
$message = "";

if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $ingredients = trim($_POST['ingredients']);
    $steps = trim($_POST['steps']);
    $image = trim($_POST['image']);
    $category = trim($_POST['category']);

    // Insert recipe into DB
    $stmt = $con->prepare("INSERT INTO recipes (name, description, ingredients, steps, image, category, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $description, $ingredients, $steps, $image, $category, $email);

    if($stmt->execute()){
        $recipe_id = $stmt->insert_id;
        $slug = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "_", $name));
        $page_name = $slug . ".php";

        // Save page_name in DB
        $update = $con->prepare("UPDATE recipes SET page_name = ? WHERE id = ?");
        $update->bind_param("si", $page_name, $recipe_id);
        $update->execute();

        // Auto-generate recipe page
        $content = '<?php
session_start();
include "config.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$id = ' . $recipe_id . ';
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
</html>';

        file_put_contents($page_name, $content);

        header("Location:index.php");
        exit;
    } else {
        $message = "⚠ Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Recipe | Veggiedelights</title>
<link rel="stylesheet" href="css/myrecipes.css" />
<style>
/* ===== FORM ===== */
form {
  max-width: 550px;
  margin: 30px auto;
  padding: 20px;
  background: #fff7ec;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  gap: 12px;
}

form input, form textarea, form select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
}

form textarea { height: 100px; }

button {
  padding: 12px;
  background: #ff7b00;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 18px;
}
button:hover { background: #e05500; }

/* ===== NAVBAR ===== */
.navbar {
  display: flex; justify-content: space-between; align-items: center;
  padding: 12px 20px; background: #ff7b00; color: #fff; flex-wrap: wrap;
}

.navbar .logo a { color: #fff; font-weight: bold; font-size: 1.5rem; text-decoration: none; }

.navbar nav { display: flex; gap: 15px; flex-wrap: wrap; }

.navbar nav a { color: #fff; text-decoration: none; font-weight: bold; padding: 6px 12px; border-radius: 6px; transition: 0.3s; }
.navbar nav a:hover { background: #fff; color: #ff7b00; }

.auth-links { display: flex; align-items: center; gap: 10px; }
.auth-links a { color: #fff; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-weight: bold; transition: 0.3s; }
.auth-links a:hover { background: #fff; color: #ff7b00; }

.welcome { color: #fff; font-weight: bold; }
.profile-icon { color: #fff; text-decoration: none; font-size: 1.3rem; }
</style>
</head>
<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="my_recipes.php">My Recipes</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
  </nav>
  <div class="auth-links">
    <a href="userprofile.php" class="profile-icon" title="Your Profile">👤</a>
    <span class="welcome">👋 <?= htmlspecialchars($email); ?></span>
    <a href="logout.php">Logout</a>
  </div>
</header>

<h1 style="text-align:center;">Add Your Recipe</h1>
<?php if($message){ echo "<p style='color:red;text-align:center;'>$message</p>"; } ?>

<form method="POST">
    <input type="text" name="name" placeholder="Recipe Name" required>
    <textarea name="description" placeholder="Short Description" required></textarea>
    <textarea name="ingredients" placeholder="Ingredients" required></textarea>
    <textarea name="steps" placeholder="Steps" required></textarea>
    <input type="text" name="image" placeholder="Image URL" required>
    <select name="category" required>
      <option value="">Select Category</option>
      <option value="North Indian">North Indian</option>
      <option value="South Indian">South Indian</option>
      <option value="Chinese">Chinese</option>
      <option value="Italian">Italian</option>
    </select>
    <button type="submit" name="submit">✅ Save Recipe</button>
</form>

</body>
</html>
