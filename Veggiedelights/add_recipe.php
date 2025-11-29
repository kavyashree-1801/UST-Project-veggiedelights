<?php
session_start();
include 'config.php';
error_reporting(0);

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
        header("Location: my_recipes.php");
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
<style>
/* ===== BODY & BACKGROUND ===== */
body {
    font-family: Arial, sans-serif;
    margin:0;
    padding:0;
    background: url('https://media.istockphoto.com/id/688530252/photo/blank-cookbook-with-fresh-ingredients-for-cooking-and-seasoning.jpg?s=612x612&w=0&k=20&c=4Mjvr38pHFNdRoRNV2BGu4kKyjR4w4w3wb95kpxNVPk=') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

/* White Overlay */
body::before {
    content: "";
    position: fixed;
    top:0; left:0;
    width:100%;
    height:100%;
    background: rgba(255,255,255,0.6); /* white overlay with 60% opacity */
    z-index: 0;
}

/* ===== NAVBAR ===== */
.navbar {
    display: flex;
    align-items: center;
    padding: 12px 30px;
    background: rgba(255, 123, 0, 0.9);
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

/* Logo left */
.navbar .logo {
    margin-right: 50px;
}
.navbar .logo a {
    color: #fff;
    font-weight: bold;
    font-size: 1.5rem;
    text-decoration: none;
}

/* Center menu items */
.nav-center {
    display: flex;
    justify-content: center;
    flex-grow: 1;
    gap: 25px;
}
.nav-center a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 6px;
    transition: 0.3s;
}
.nav-center a:hover,
.nav-center a.active {
    background: #fff;
    color: #ff7b00;
}

/* Profile / auth links right */
.auth-links {
    display: flex;
    align-items: center;
    gap: 12px;
}
.auth-links a {
    color: #fff;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: bold;
    transition: 0.3s;
}
.auth-links a:hover {
    background: #fff;
    color: #ff7b00;
}

.profile-icon { font-size: 1.3rem; }
.welcome { font-weight: bold; color: #fff; }

/* ===== FORM ===== */
h1 {
    text-align:center;
    color:#ff7b00;
    margin-top:40px;
    position: relative;
    z-index:1;
}
form {
    max-width: 700px; /* stretched wider */
    margin: 30px auto;
    padding: 25px;
    background: rgba(255, 255, 255, 0.95); /* white semi-transparent form */
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    gap: 14px;
    position: relative;
    z-index: 1;
}
form input, form textarea, form select {
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
}
form textarea { height: 120px; }

button {
    padding: 14px;
    background: #ff7b00;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    transition: 0.3s;
}
button:hover { background: #e05500; }

/* ===== FOOTER ===== */
footer {
    text-align:center;
    padding:20px;
    background: #ff7b00;
    color:#fff;
    margin-top:40px;
    font-weight:bold;
    position: relative;
    z-index: 1;
}

/* ===== RESPONSIVE ===== */
@media(max-width: 768px){
    form { width: 90%; }
    .nav-center { gap: 15px; flex-wrap: wrap; }
}
</style>
</head>
<body>

<header class="navbar">
    <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
    <nav class="nav-center">
        <a href="index.php">Home</a>
        <a href="category.php">Categories</a>
        <a href="contact.php">Contact</a>
        <a href="feedback.php">Feedback</a>
        <a href="my_recipes.php">My Recipes</a>
    </nav>
    <div class="auth-links">
        <a href="userprofile.php" class="profile-icon" title="Your Profile">👤</a>
        <span class="welcome">👋 <?= htmlspecialchars($email); ?></span>
        <a href="logout.php">Logout</a>
    </div>
</header>

<h1>Add Your Recipe</h1>
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

<footer>
    © 2025 Veggiedelights |All rights reserved 
</footer>

</body>
</html>
