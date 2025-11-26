<?php
session_start();
include 'config.php'; // Your DB connection in $con

$searchTerm = '';
$recipes = [];

if (isset($_GET['q'])) {
    $searchTerm = trim($_GET['q']);

    // Prepared statement to avoid SQL injection
    $stmt = $con->prepare("SELECT * FROM recipes WHERE name LIKE ? ORDER BY id DESC");
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }
    $stmt->close();
} else {
    // Show all recipes if no search term
    $result = $con->query("SELECT * FROM recipes ORDER BY id DESC");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Recipes | Veggiedelights</title>
<link rel="stylesheet" href="css/styles.css">

<style>
/* ===================== Navbar ===================== */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  background: #ff7b00;
  color: white;
  position: sticky;
  top: 0;
  z-index: 1000;
  flex-wrap: wrap;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.navbar .logo a {
  color: white;
  font-size: 26px;
  font-weight: bold;
  text-decoration: none;
}

nav {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: 500;
  padding: 6px 10px;
  border-radius: 5px;
  transition: 0.3s;
}

nav a:hover,
nav a.active {
  background: #ff9933;
  color: #fffbea;
}

.auth-links {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.welcome {
  color: #fff;
  font-weight: bold;
  font-size: 0.95em;
}

.profile-icon {
  font-size: 1.3em;
  color: white;
  text-decoration: none;
}

/* ===================== Recipe Cards ===================== */
main {
  max-width: 1200px;
  margin: 40px auto;
  padding: 0 20px;
}

form.search-form {
  text-align: center;
  margin-bottom: 30px;
}

form.search-form input[type="text"] {
  width: 300px;
  padding: 10px;
  font-size: 16px;
  border: 2px solid #ddd;
  border-radius: 5px;
}

form.search-form button {
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  background: #ff7b00;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
}

form.search-form button:hover {
  background: #e67300;
}

.recipe-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.recipe-card {
  background: #fff;
  width: 350px;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: transform 0.3s;
}

.recipe-card:hover {
  transform: translateY(-5px);
}

.recipe-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.recipe-content {
  padding: 15px 20px;
}

.recipe-content h2 {
  margin: 0 0 10px;
  color: #ff7b00;
}

.recipe-content p.description {
  font-size: 14px;
  color: #555;
  margin-bottom: 10px;
}

.recipe-content h3 {
  margin: 10px 0 5px;
  color: #333;
  font-size: 16px;
}

.recipe-content ul {
  padding-left: 20px;
  margin: 0 0 10px;
}

.recipe-content pre {
  white-space: pre-wrap;
  font-family: inherit;
  color: #555;
  margin:0;
}

.no-results {
  text-align: center;
  color: #999;
  font-size: 18px;
  margin-top: 30px;
}

@media(max-width: 768px) {
  .recipe-card {
    width: 90%;
  }
}
</style>
</head>
<body>

<!-- ===================== Navbar ===================== -->
<header class="navbar">
  <div class="logo">
    <a href="index.php">🥘 Veggiedelights</a>
  </div>

  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>

  <div class="auth-links">
    <?php
    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        echo '<a href="userprofile.php" class="profile-icon" title="Your Profile">👤</a>';
        echo '<span class="welcome">👋 ' . htmlspecialchars($_SESSION['email']) . '</span>';
        echo '<a href="logout.php" class="nav-link">Logout</a>';
    } else {
        echo '<a href="login.php" class="nav-link">Login</a>';
    }
    ?>
  </div>
</header>

<!-- ===================== Main Content ===================== -->
<main>
  <form class="search-form" method="get" action="">
    <input type="text" name="q" placeholder="Enter recipe name" value="<?php echo htmlspecialchars($searchTerm); ?>">
    <button type="submit">Search</button>
  </form>

  <div class="recipe-container">
    <?php if (!empty($recipes)) : ?>
      <?php foreach ($recipes as $recipe) : ?>
        <div class="recipe-card">
          <?php if (!empty($recipe['image'])): ?>
            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>">
          <?php else: ?>
            <img src="placeholder.png" alt="No image">
          <?php endif; ?>

          <div class="recipe-content">
            <h2><?php echo htmlspecialchars($recipe['name']); ?></h2>
            <p class="description"><?php echo htmlspecialchars($recipe['description']); ?></p>

            <?php if (!empty($searchTerm)) : ?>
              <!-- Only show ingredients and steps if search is performed -->
              <h3>Ingredients:</h3>
              <ul>
                <?php
                $ingredients = explode("\n", $recipe['ingredients']);
                foreach ($ingredients as $ing) {
                    echo "<li>" . htmlspecialchars($ing) . "</li>";
                }
                ?>
              </ul>

              <h3>Steps:</h3>
              <pre><?php echo htmlspecialchars($recipe['steps']); ?></pre>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="no-results">No recipe found.</p>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
