<?php
session_start();

// CAPTCHA generation
$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['captcha_answer'] = $num1 + $num2;
?>
<!DOCTYPE html>
<html>
<head>
    <title>VeggieDelights – Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
<div class="container">
    <h2>🥘 VeggieDelights Signup</h2>
    <p id="msg"></p>

    <form id="signupForm" enctype="multipart/form-data">
        <label for="name">Full Name</label>
        <input class="input-field" name="name" id="name" type="text" placeholder="Enter your full name" required>
        <div id="nameHint" class="hint"></div>

        <label for="email">Email</label>
        <input class="input-field" name="email" id="email" type="email" placeholder="Enter your email" required>
        <div id="emailHint" class="hint"></div>

        <label for="profile_pic">Profile Picture</label>
        <input class="input-field" name="profile_pic" id="profile_pic" type="file" accept="image/*">
        <div id="picHint" class="hint"></div>

        <label for="password">Password</label>
        <div class="password-box">
            <input class="input-field" name="password" id="password" type="password" placeholder="Enter password" required>
            <span class="eye" onclick="togglePassword('password')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </span>
            <div class="tooltip">Password must have: 1 uppercase, 1 lowercase, 1 number, 1 special character, min 8 chars</div>
        </div>
        <div id="passwordHint" class="hint"></div>
        <div id="passwordStrength"></div>

        <label for="confirm_password">Confirm Password</label>
        <div class="password-box">
            <input class="input-field" name="confirm_password" id="confirm_password" type="password" placeholder="Confirm password" required>
            <span class="eye" onclick="togglePassword('confirm_password')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </span>
        </div>
        <div id="confirmHint" class="hint"></div>

        <label for="security_question">Security Question</label>
        <select name="security_question" id="security_question" required>
            <option value="">Select Security Question</option>
            <option value="favorite_vegetable">What is your favorite vegetable?</option>
            <option value="birth_city">What city were you born in?</option>
        </select>
        <div id="questionHint" class="hint"></div>

        <label for="security_answer">Security Answer</label>
        <input class="input-field" name="security_answer" id="security_answer" type="text" placeholder="Enter answer" required>
        <div id="answerHint" class="hint"></div>

        <label for="captcha">CAPTCHA: Solve <?= $num1 ?> + <?= $num2 ?> = ?</label>
        <input class="input-field" name="captcha" id="captcha" type="number" placeholder="Enter answer" required>
        <div id="captchaHint" class="hint"></div>

        <button class="btn" type="submit" name="submit">Create Account</button>
    </form>

    <p class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

<script>
function togglePassword(fieldId){
    const field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}

// ===== LIVE HINTS & VALIDATION =====
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('confirm_password');
const questionInput = document.getElementById('security_question');
const answerInput = document.getElementById('security_answer');
const captchaInput = document.getElementById('captcha');
const profilePic = document.getElementById('profile_pic');

const nameHint = document.getElementById('nameHint');
const emailHint = document.getElementById('emailHint');
const passwordHint = document.getElementById('passwordHint');
const confirmHint = document.getElementById('confirmHint');
const questionHint = document.getElementById('questionHint');
const answerHint = document.getElementById('answerHint');
const captchaHint = document.getElementById('captchaHint');
const picHint = document.getElementById('picHint');
const passwordStrength = document.getElementById('passwordStrength');

function isValidEmail(email){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); }
function checkPasswordStrength(pwd){
    let strength = 0;
    if(pwd.length >= 8) strength++;
    if(/[A-Z]/.test(pwd)) strength++;
    if(/[a-z]/.test(pwd)) strength++;
    if(/[0-9]/.test(pwd)) strength++;
    if(/[\W_]/.test(pwd)) strength++;
    return strength;
}

nameInput.addEventListener('input', ()=>{
    const val = nameInput.value.trim();
    nameHint.textContent = val.length >= 2 ? "✔ Looks good" : "Name must be at least 2 characters";
    nameHint.className = val.length>=2 ? "hint valid" : "hint invalid";
});

emailInput.addEventListener('input', ()=>{
    const val = emailInput.value.trim();
    emailHint.textContent = isValidEmail(val) ? "✔ Valid email" : "Enter a valid email";
    emailHint.className = isValidEmail(val) ? "hint valid" : "hint invalid";
});

passwordInput.addEventListener('input', ()=>{
    const val = passwordInput.value;
    const strength = checkPasswordStrength(val);
    passwordStrength.style.width = (strength*20)+"%";
    passwordStrength.style.background = strength<3 ? "red" : strength<4 ? "orange" : "green";

    passwordHint.textContent = strength>=4 ? "✔ Strong password" : "Password must have uppercase, lowercase, number & special char";
    passwordHint.className = strength>=4 ? "hint valid" : "hint invalid";

    // Confirm password live check
    if(confirmInput.value){
        confirmHint.textContent = val === confirmInput.value ? "✔ Passwords match" : "Passwords do not match";
        confirmHint.className = val === confirmInput.value ? "hint valid" : "hint invalid";
    }
});

confirmInput.addEventListener('input', ()=>{
    confirmHint.textContent = confirmInput.value === passwordInput.value ? "✔ Passwords match" : "Passwords do not match";
    confirmHint.className = confirmInput.value === passwordInput.value ? "hint valid" : "hint invalid";
});

questionInput.addEventListener('change', ()=>{
    questionHint.textContent = questionInput.value ? "✔ Selected" : "Select a security question";
    questionHint.className = questionInput.value ? "hint valid" : "hint invalid";
});

answerInput.addEventListener('input', ()=>{
    const val = answerInput.value.trim();
    answerHint.textContent = val.length>=2 ? "✔ Looks good" : "Answer must be at least 2 characters";
    answerHint.className = val.length>=2 ? "hint valid" : "hint invalid";
});

captchaInput.addEventListener('input', ()=>{
    const val = parseInt(captchaInput.value);
    captchaHint.textContent = val === <?= $_SESSION['captcha_answer'] ?> ? "✔ Correct" : "Incorrect answer";
    captchaHint.className = val === <?= $_SESSION['captcha_answer'] ?> ? "hint valid" : "hint invalid";
});

profilePic.addEventListener('change', ()=>{
    const file = profilePic.files[0];
    if(file && file.size > 2*1024*1024){ picHint.textContent="Max size 2MB"; picHint.className="hint invalid"; }
    else{ picHint.textContent="✔ Looks good"; picHint.className="hint valid"; }
});

// ===== FORM SUBMIT =====
document.getElementById("signupForm").addEventListener("submit", function(e){
    e.preventDefault();

    if(nameInput.value.trim().length<2 ||
       !isValidEmail(emailInput.value.trim()) ||
       checkPasswordStrength(passwordInput.value)<4 ||
       passwordInput.value!==confirmInput.value ||
       !questionInput.value ||
       answerInput.value.trim().length<2 ||
       parseInt(captchaInput.value) !== <?= $_SESSION['captcha_answer'] ?>){
        alert("Please fix errors before submitting!");
        return;
    }

    let formData = new FormData(this);
    let msg = document.getElementById("msg");

    fetch("api/signups.php", {
        method: "POST",
        body: formData,
        credentials: "include"
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            msg.className = "success";
            msg.innerText = "Account created! Redirecting...";
            setTimeout(()=> window.location.href="login.php", 1500);
        } else {
            msg.className = "error";
            msg.innerText = data.error;
        }
    })
    .catch(()=> { msg.className="error"; msg.innerText="Server error!"; });
});
</script>
</body>
</html>
