<?php
session_start();
include 'config.php';

// Set role and email
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? $_SESSION['username'] ?? 'Guest';

if (!$email || $role === 'guest') {
    header('Location: login.php');
    exit;
}

// Fetch user info
$sql = "SELECT name, security_question, profile_pic FROM signup WHERE email=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = $user['name'];
$security_question = $user['security_question'];
$profile_pic = $user['profile_pic'] ?: 'https://cdn-icons-png.flaticon.com/512/149/149071.png';

// Greeting based on time
date_default_timezone_set('Asia/Kolkata');
$hour = date('H');
if ($hour < 12) $greeting = "Good Morning";
elseif ($hour < 17) $greeting = "Good Afternoon";
elseif ($hour < 20) $greeting = "Good Evening";
else $greeting = "Good Night";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Profile | Veggiedelights</title>
<link rel="stylesheet" href="css/index.css">
<style>
/* Profile page specific styles */
body {
    font-family: "Poppins", sans-serif;
    background: url('https://img.freepik.com/free-photo/top-view-different-seasonings-with-fresh-vegetables-dark-desk-spicy-pepper-food-salad-health_140725-86007.jpg') no-repeat center center fixed;
    background-size: cover;
    padding-top: 100px;
    min-height: 100vh;
}
.profile-container {
    background: rgba(255,255,255,0.95);
    max-width: 520px;
    margin: auto;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}
.profile-container h1 {
    text-align: center;
    color: #ff7b00;
    margin-bottom: 20px;
}
.profile-pic {
    text-align: center;
    margin-bottom: 15px;
}
.profile-pic img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #ff7b00;
    background: white;
    padding: 5px;
    object-fit: cover;
}
.input-group {
    margin-bottom: 18px;
}
.input-group label {
    font-weight: 600;
    color: #ff7b00;
    display: block;
    margin-bottom: 6px;
}
.input-group input {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: 2px solid #ddd;
    font-size: 15px;
    transition: 0.3s ease;
    background: white;
}
.input-group input:focus {
    border-color: #ff7b00;
    background: #fff9f1;
    box-shadow: 0 0 6px rgba(255,123,0,0.3);
}
button {
    background: #ff7b00;
    color: #fff;
    border: none;
    padding: 14px;
    width: 100%;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}
button:hover {
    background: #ff8f20;
}
.hint {
    font-size: 13px;
    color: gray;
    margin-top: 4px;
}
.hint.valid {
    color: green;
}
.hint.invalid {
    color: red;
}
#msg {
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
}
footer {
    background: #ff7b00;
    color: white;
    text-align: center;
    padding: 15px 0;
    font-weight: bold;
    width: 100%;
    margin-top: 30px;
}

/* Navbar overrides to match index.css */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: #ff7b00;
    color: white;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.25);
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
}
nav a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 6px 10px;
    border-radius: 5px;
    transition: 0.3s;
}
nav a:hover, nav a.active {
    background: white;
    color: #ff7b00;
}
.auth-links {
    display: flex;
    align-items: center;
    gap: 15px;
}
.auth-links a.profile-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #ff7b00;
    font-weight: bold;
    text-decoration: none;
}
.auth-links .welcome {
    color: #fff;
    font-weight: bold;
}
.auth-links a:hover {
    opacity: 0.8;
}
</style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="category.php">Categories</a>
    <a href="contact.php">Contact</a>
    <a href="feedback.php">Feedback</a>
    <a href="my_recipes.php">My Recipes</a>
  </nav>
  <div class="auth-links">
    <a href="userprofile.php" class="profile-btn">👤</a>
    <span class="welcome">👋 Hello <?= htmlspecialchars($email); ?></span>
    <a href="logout.php">Logout</a>
  </div>
</header>

<!-- ===== PROFILE SECTION ===== -->
<div class="profile-container">
  <h1>👤 Your Profile</h1>
  <div id="msg"></div>
  <form id="profileForm" enctype="multipart/form-data">
    <div class="profile-pic">
        <img src="<?= $profile_pic ?>" id="profileImg">
        <input type="file" name="profile_pic" accept="image/*">
        <div id="picHint" class="hint"></div>
    </div>
    <div class="input-group">
        <label>Your Name</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>
        <div id="nameHint" class="hint"></div>
    </div>
    <div class="input-group">
        <label>Email Address</label>
        <input type="email" value="<?= htmlspecialchars($email) ?>" readonly>
    </div>
    <div class="input-group">
        <label>Security Question</label>
        <input type="text" value="<?= htmlspecialchars($security_question) ?>" readonly>
    </div>
    <div class="input-group">
        <label>New Security Answer</label>
        <input type="text" name="security_answer" id="security_answer" placeholder="Enter new answer">
        <div id="answerHint" class="hint"></div>
    </div>
    <button type="submit">💾 Save Profile</button>
  </form>
</div>

<footer>
  © 2025 Veggiedelights | All Rights Reserved
</footer>

<script>
const nameInput = document.getElementById('name');
const answerInput = document.getElementById('security_answer');
const profilePic = document.querySelector('input[name="profile_pic"]');

const nameHint = document.getElementById('nameHint');
const answerHint = document.getElementById('answerHint');
const picHint = document.getElementById('picHint');

nameInput.addEventListener('input', ()=>{
    const val = nameInput.value.trim();
    nameHint.textContent = val.length>=2 ? "✔ Looks good" : "Name must be at least 2 characters";
    nameHint.className = val.length>=2 ? "hint valid" : "hint invalid";
});

answerInput.addEventListener('input', ()=>{
    const val = answerInput.value.trim();
    answerHint.textContent = val.length>=2 ? "✔ Looks good" : "Answer must be at least 2 characters";
    answerHint.className = val.length>=2 ? "hint valid" : "hint invalid";
});

profilePic.addEventListener('change', ()=>{
    const file = profilePic.files[0];
    if(file && file.size>2*1024*1024){ 
        picHint.textContent="Max 2MB"; 
        picHint.className="hint invalid"; 
    }
    else{ 
        picHint.textContent="✔ Looks good"; 
        picHint.className="hint valid"; 
    }
});

document.getElementById('profileForm').addEventListener('submit', async (e)=>{
  e.preventDefault();
  if(nameInput.value.trim().length<2 || (answerInput.value && answerInput.value.trim().length<2)){
      alert("Please fix errors before submitting!");
      return;
  }

  const formData = new FormData(e.target);
  const msgBox = document.getElementById('msg');

  try{
    const res = await fetch('api/update_profile.php', { method:'POST', body: formData });
    const data = await res.json();
    msgBox.textContent = data.msg;
    msgBox.style.color = data.success ? 'green':'red';
    if(data.success && data.profile_pic){
        document.getElementById('profileImg').src = data.profile_pic;
    }
  } catch(err){
    msgBox.textContent = '⚠ Something went wrong!';
    msgBox.style.color = 'red';
  }
});
</script>

</body>
</html>
