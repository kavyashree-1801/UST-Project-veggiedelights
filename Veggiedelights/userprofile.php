<?php
session_start();
include 'config.php'; // your DB connection

$email = $_SESSION['email'] ?? null;
$role = $_SESSION['role'] ?? 'guest'; // assuming you store user role in session

if (!$email) {
    header('Location: login.php');
    exit;
}

// Fetch user info
$sql = "SELECT name, security_question FROM signup WHERE email=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = $user['name'];
$security_question = $user['security_question'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>User Profile | Veggiedelights</title>
<link rel="stylesheet" href="css/styles.css" />
<style>
/* ====== NAVBAR ====== */
header.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #ff7b00;
  padding: 12px 20px;
  flex-wrap: wrap;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 100;
}
header.navbar .logo a {
  font-size: 1.5rem;
  font-weight: bold;
  color: #fff;
  text-decoration: none;
}
header.navbar nav {
  display: flex;
  align-items: center;
  gap: 25px;
}
header.navbar nav a {
  color: #fff;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 5px;
  transition: 0.3s;
}
header.navbar nav a:hover {
  background: #fff;
  color: #ff7b00;
}
.dropdown {
  position: relative;
}
.dropdown-content {
  display: none;
  position: absolute;
  top: 45px;
  left: 0;
  background-color: #ff7b00;
  min-width: 180px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  flex-direction: column;
  z-index: 10;
}
.dropdown-content a {
  color: #fff;
  padding: 10px 15px;
  text-decoration: none;
  border-bottom: 1px solid rgba(255,255,255,0.2);
}
.dropdown-content a:hover {
  background: #fff;
  color: #ff7b00;
}
.dropdown:hover .dropdown-content {
  display: flex;
}
.auth-links {
  display: flex;
  align-items: center;
  gap: 10px;
}
.nav-link {
  background: #fff;
  color: #ff7b00;
  padding: 6px 12px;
  border-radius: 5px;
  text-decoration: none;
}
.nav-link:hover {
  background: #ff7b00;
  color: #fff;
}

/* ===== PROFILE CONTAINER ===== */
body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background: url('https://img.freepik.com/free-photo/top-view-different-seasonings-with-fresh-vegetables-dark-desk-spicy-pepper-food-salad-health_140725-86007.jpg?semt=ais_hybrid&w=740&q=80') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    padding-top: 100px;
}
body::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.1));
    z-index: 0;
}
.profile-container {
    position: relative;
    z-index: 1;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 40px;
    width: 100%;
    max-width: 480px;
    text-align: left;
    backdrop-filter: blur(10px);
}
.profile-container h1 {
    color: #ff7b00;
    font-size: 2rem;
    text-align: center;
    margin-bottom: 25px;
}
form { display: flex; flex-direction: column; gap: 18px; }
input[type="text"], input[type="email"], input[type="file"], textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
input:focus, textarea:focus {
    border-color: #ffa94d;
    box-shadow: 0 0 0 3px rgba(255,179,71,0.3);
}
textarea { resize: none; min-height: 80px; }
.profile-pic { display: flex; flex-direction: column; align-items: center; margin-bottom: 10px; }
.profile-pic img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #ff7b00; margin-bottom: 10px; }
button[type="submit"] {
    background: #ff7b00;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}
button[type="submit"]:hover { background: #ff8f26; }
.logout-link { text-align: center; margin-top: 15px; font-size: 0.9rem; }
.logout-link a { color: #ff7b00; text-decoration: none; font-weight: 600; }
.logout-link a:hover { text-decoration: underline; }
</style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <?php if ($role === 'user'): ?>
      <a href="about.php">About</a>
      <a href="Category.php">Categories</a>
      <a href="contact.php">Contact</a>
      <a href="feedback.php">Feedback</a>
      <a href="my_recipes.php">My Recipes</a>
    <?php endif; ?>
    <?php if ($role === 'admin'): ?>
    <div class="dropdown">
      <a href="#">Admin Panel ▾</a>
      <div class="dropdown-content">
        <a href="view_users.php">Manage Users</a>
        <a href="view_recipes.php">Manage Recipes</a>
        <a href="manage_categories.php">Manage Categories</a>
        <a href="view_feedback.php">Manage Feedback</a>
        <a href="view_contact.php">Manage Contact</a>
      </div>
    </div>
    <?php endif; ?>
  </nav>
  <div class="auth-links">
    <?php if ($role === 'admin'): ?>
      <span class="welcome">👋 Hello Admin</span>
      <a href="logout.php" class="nav-link">Logout</a>
    <?php elseif ($role === 'user'): ?>
      <a href="userprofile.php" title="Your Profile" style="
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: #fff;
        color: #ff7b00;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
      " 
      onmouseover="this.style.background='#ff7b00'; this.style.color='#fff';" 
      onmouseout="this.style.background='#fff'; this.style.color='#ff7b00';">
        👤
      </a>
      <span class="welcome">👋 Hello <?php echo htmlspecialchars($email); ?></span>
      <a href="logout.php" class="nav-link">Logout</a>
    <?php else: ?>
      <a href="login.php" class="nav-link">Login</a>
      <a href="admin_login.php" class="nav-link">Admin</a>
    <?php endif; ?>
  </div>
</header>

<!-- ===== PROFILE FORM ===== -->
<div class="profile-container">
<h1>👤 Your Profile</h1>
<form id="profileForm" enctype="multipart/form-data">
    <div class="profile-pic">
        <img id="preview" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Profile Picture" />
        <input type="file" name="profile_pic" accept="image/*" id="profilePicInput" />
    </div>

    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Full Name" required />
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" readonly />
    
    <input type="text" name="security_question" value="<?php echo htmlspecialchars($security_question); ?>" placeholder="Security Question" required />
    <input type="text" name="security_answer" placeholder="Enter new answer to change it" />

    <button type="submit">💾 Save Profile</button>
    <p class="logout-link"><a href="logout.php">Logout</a></p>
</form>
</div>

<script>
// Local preview for profile picture
const profileInput = document.getElementById('profilePicInput');
const preview = document.getElementById('preview');
profileInput.addEventListener('change', () => {
    const file = profileInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(file);
    }
});

// AJAX save profile
const form = document.getElementById('profileForm');
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(form);
    formData.append('ajax', '1');

    fetch('save_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.success){
            window.location.href = 'index.php'; // redirect after update
        }
    })
    .catch(err => console.error('Error:', err));
});
</script>
</body>
</html>
