<?php
session_start();

// Generate CAPTCHA
$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['login_captcha_answer'] = $num1 + $num2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | VeggieDelights</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/login.css">

<style>
label{font-weight:600;margin-top:12px;display:block;color:#333}

/* Password box */
.password-box{position:relative}
.eye{
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
}

/* Tooltip */
.tooltip{
    position:absolute;
    top:110%;
    left:0;
    background:#333;
    color:#fff;
    font-size:12px;
    padding:8px;
    border-radius:6px;
    width:240px;
    display:none;
    z-index:5;
}
.tooltip span{display:block}
.valid{color:#4CAF50}
.invalid{color:#ff5252}

/* Remember row */
.remember-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:12px;
}
.remember-left{
    display:flex;
    align-items:center;
    gap:6px;
    cursor:pointer;
}
.forgot-link{
    color:#ff7b00;
    text-decoration:none;
    font-weight:600;
}
.forgot-link:hover{text-decoration:underline}

input.invalid{border-color:red;background:#ffe5e5}
.error{text-align:center;color:red;font-weight:bold;margin-bottom:10px}
.signup-text{text-align:center;margin-top:15px}
.signup-text a{color:#ff7b00;font-weight:bold;text-decoration:none}
</style>
</head>

<body>
<div class="container">
<h2>🔒 Login</h2>
<div id="error" class="error"></div>

<form id="loginForm">

<label>Email</label>
<input type="email" id="email" placeholder="Enter your email" required>

<label>Password</label>
<div class="password-box">
<input type="password" id="password" placeholder="Enter password" required>

<span class="eye" onclick="togglePassword()">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2">
<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
<circle cx="12" cy="12" r="3"/>
</svg>
</span>

<div class="tooltip" id="passwordTooltip">
<span id="u" class="invalid">• Uppercase letter</span>
<span id="l" class="invalid">• Lowercase letter</span>
<span id="s" class="invalid">• Special character</span>
<span id="len" class="invalid">• Minimum 6 characters</span>
</div>
</div>

<label>CAPTCHA: Solve <?= $num1 ?> + <?= $num2 ?></label>
<input type="number" id="captcha" placeholder="Answer" required>

<div class="remember-row">
<label class="remember-left">
<input type="checkbox" id="rememberMe">
<span>Remember Me</span>
</label>
<a href="forgot_password.php" class="forgot-link">Forgot Password?</a>
</div>

<button type="submit">Login</button>
</form>

<div class="signup-text">
Don’t have an account?
<a href="signup.php">Create Account</a>
</div>
</div>

<script src="js/login.js"></script>
</body>
</html>
