<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password | VeggieDelights</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="container">
    <h2>Forgot Password</h2>
    <p class="subtitle">Verify using your security question</p>

    <div class="error" id="error"></div>
    <div class="success" id="success"></div>

    <!-- STEP 1 -->
    <div id="step1">
        <input type="email" id="email" placeholder="Enter your email">
        <button type="button" onclick="getQuestion()">Next</button>
    </div>

    <!-- STEP 2 -->
    <div id="step2" style="display:none;">
        <p id="question" style="font-weight:bold;"></p>
        <input type="text" id="answer" placeholder="Your answer">
        <div class="password-box">
            <input type="password" id="newPassword" placeholder="New password">
            <span class="eye" onclick="togglePassword('newPassword')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </span>
        </div>
        <button type="button" onclick="resetPassword()">Reset Password</button>
    </div>

    <div class="links">
        <a href="login.php">Back to Login</a>
    </div>
</div>

<script src="js/forgot_password.js"></script>

</body>
</html>
