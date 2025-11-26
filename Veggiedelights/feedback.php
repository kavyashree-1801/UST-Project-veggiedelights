<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback | Veggiedelights</title>
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

    /* ===================== Feedback Form ===================== */
    main {
      max-width: 700px;
      margin: 60px auto 50px auto;
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #ff7b00;
      margin-bottom: 20px;
      font-size: 2rem;
    }

    p.subtext {
      text-align: center;
      margin-bottom: 30px;
      color: #555;
      font-size: 1.05rem;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    label {
      font-weight: 600;
      color: #333;
      margin-bottom: 4px;
    }

    input[type="text"],
    input[type="email"],
    textarea,
    select {
      width: 100%;
      padding: 12px 14px;
      border: 1.8px solid #dcdcdc;
      border-radius: 8px;
      font-size: 1rem;
      background: #fafafa;
      transition: all 0.25s ease;
    }

    input:focus,
    textarea:focus,
    select:focus {
      border-color: #ff7b00;
      background: #fff;
      outline: none;
      box-shadow: 0 0 6px rgba(255, 123, 0, 0.35);
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    button {
      background: #ff7b00;
      color: white;
      padding: 14px;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s;
    }

    button:hover {
      background: #e67300;
      transform: translateY(-2px);
    }

    button:active {
      transform: translateY(0);
    }

    footer {
      text-align: center;
      padding: 15px;
      margin-top: 50px;
      background: #333;
      color: #fff;
    }

    /* ===================== Responsive ===================== */
    @media(max-width: 600px) {
      main {
        margin: 20px;
        padding: 20px;
      }

      nav {
        justify-content: center;
      }

      button {
        padding: 12px;
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
      <a href="feedback.php" class="active">Feedback</a>
      <a href="my_recipes.php">My Recipes</a>
    </nav>

    <div class="auth-links">
      <?php
      if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
          echo '<a href="userprofile.php" class="profile-icon" title="Your Profile">👤</a>';
          echo '<span class="welcome">👋 ' . htmlspecialchars($_SESSION['email']) . '</span>';
          echo '<a href="logout.php" class="nav-link"><span class="acc">Logout</span></a>';
      } else {
          echo '<a href="login.php" class="nav-link"><span class="acc">Login</span></a>';
      }
      ?>
    </div>
  </header>

  <!-- ===================== Feedback Form ===================== -->
  <main>
    <h1>💬 We Value Your Feedback!</h1>
    <p class="subtext">Share your thoughts and help us make Veggiedelights even better 🌱</p>

    <form method="post" action="save_feedback.php">
      <label>Your Name</label>
      <input type="text" name="name" placeholder="Enter your name" required>

      <label>Your Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Your Rating</label>
      <select name="rating" required>
        <option value="">Select Rating</option>
        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
        <option value="4">⭐⭐⭐⭐ Good</option>
        <option value="3">⭐⭐⭐ Average</option>
        <option value="2">⭐⭐ Poor</option>
        <option value="1">⭐ Very Poor</option>
      </select>

      <label>Your Feedback</label>
      <textarea name="message" rows="5" placeholder="Tell us about your experience..." required></textarea>

      <button type="submit">📨 Submit Feedback</button>
    </form>
  </main>

  <!-- ===================== Footer ===================== -->
  <footer>
    <p>Made with ❤️ by You | © 2025 Veggiedelights</p>
  </footer>
</body>
</html>
