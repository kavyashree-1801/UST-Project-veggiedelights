<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | Veggiedelights</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f8f8f8;
      color: #333;
    }

    /* ✅ SAME NAVBAR AS ABOUT PAGE */
    .navbar {
      background: #ff7b00;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 40px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .logo a {
      text-decoration: none;
      font-size: 1.8em;
      font-weight: bold;
      color: #fff;
    }

    nav {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 25px;
    }

    nav a {
      text-decoration: none;
      color: #fffbea;
      font-weight: bold;
      font-size: 1em;
      padding: 6px 10px;
      transition: background 0.3s ease, color 0.3s ease;
      border-radius: 5px;
    }

    nav a:hover,
    nav a.active {
      background: #ff9933;
      color: #fffbea;
    }

    .auth-links {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .welcome {
      color: #fff;
      font-weight: bold;
      font-size: 0.95em;
    }

    #themeToggle {
      background: none;
      border: 2px solid #fff;
      color: #fff;
      font-size: 1.1em;
      border-radius: 50%;
      width: 34px;
      height: 34px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    #themeToggle:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    /* ✅ PROFILE ICON CIRCLE */
    .profile-icon {
      width: 38px;
      height: 38px;
      border-radius: 50%; /* perfect circle */
      background: #fff;
      color: #ff7b00;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 20px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .profile-icon:hover {
      background: #ff7b00;
      color: #fff;
      transform: scale(1.1);
    }

    /* ✅ CONTACT FORM */
    .contact-container {
      max-width: 650px;
      margin: 60px auto;
      padding: 40px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .contact-container h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #ff6600;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      border: 2px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
      margin-bottom: 18px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #ff6600;
      color: #fff;
      border: none;
      font-size: 1.1rem;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #e67300;
    }

    footer {
      text-align: center;
      padding: 20px;
      background: #222;
      color: #fff;
      margin-top: 60px;
    }
  </style>
</head>

<body>

<header class="navbar">
  <div class="logo"><a href="index.php">🥘veggiedelights</a></div>

  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="Category.php">Categories</a>
    <a href="contact.php" class="active">Contact</a>
    <a href="feedback.php">Feedback</a>
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

<main>
  <div class="contact-container">
    <h1>📬 Contact Us</h1>

    <form method="POST" action="save_contact.php">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email" required />
      <input type="text" name="subject" placeholder="Subject" required />
      <textarea name="message" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</main>

<footer>
  <p>Made with ❤️ by You | © 2025 Veggiedelights</p>
</footer>

</body>
</html>
