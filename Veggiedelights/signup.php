<?php 
session_start();

// Generate CAPTCHA numbers
$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['captcha_answer'] = $num1 + $num2;
?>
<!DOCTYPE html>
<html>
<head>
    <title>VeggieDelights – Signup</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: url("https://img.freepik.com/premium-photo/ingredients-recipe-wooden-background_1049143-28691.jpg") no-repeat center center fixed;
            background-size: cover;

            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 40px;
            overflow-y: scroll;
        }

        /* Floating veggies */
        .veggie {
            position: absolute;
            width: 70px;
            opacity: 0.25;
            animation: float 10s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(110vh) rotate(0deg); }
            100% { transform: translateY(-120vh) rotate(360deg); }
        }

        /* FORM CONTAINER */
        .container {
            width: 420px;
            background: rgba(255,255,255,0.92);
            border-radius: 18px;
            padding: 35px 40px;
            box-shadow: 0 0 25px rgba(0,0,0,0.2);
            border-top: 6px solid #ff7b00;
            backdrop-filter: blur(4px);
            text-align: center;
            z-index: 10;
        }

        h2 {
            color: #ff7b00;
            margin-bottom: 20px;
        }

        /* UNIFORM FIELDS */
        .input-field,
        select {
            width: 100%;
            padding: 13px;
            margin: 12px 0;
            border-radius: 10px;
            border: 2px solid #ffa54a;
            font-size: 15px;
            transition: 0.2s ease;
            outline: none;
        }

        .input-field:focus,
        select:focus {
            border-color: #ff7b00;
            box-shadow: 0 0 5px rgba(255,123,0,0.4);
        }

        /* PROFILE PIC PREVIEW */
        #previewImg {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ff7b00;
            margin-top: 10px;
            display: none;
        }

        /* PASSWORD */
        .password-box {
            position: relative;
            width: 100%;
        }

        .toggle-eye {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #ff7b00;
        }

        /* Strength Bar */
        #strengthBar {
            width: 100%;
            height: 8px;
            background: #eee;
            border-radius: 5px;
            margin-top: 5px;
        }
        #strength {
            height: 8px;
            width: 0%;
            background: red;
            border-radius: 5px;
            transition: 0.3s;
        }

        .match-msg { font-size: 12px; margin-top: -5px; height: 18px; }

        .btn {
            width: 100%;
            padding: 13px;
            background: #ff7b00;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            cursor: pointer;
            margin-top: 18px;
            transition: 0.2s;
            font-weight: bold;
        }

        .btn:hover {
            background: #e96f00;
        }

        /* Login button */
        .login-btn {
            width: 100%;
            padding: 13px;
            background: #555;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            cursor: pointer;
            margin-top: 12px;
            transition: 0.2s;
            font-weight: bold;
        }
        .login-btn:hover {
            background: #333;
        }
    </style>
</head>

<body>

<!-- floating veggies -->
<img src="img/carrot.png" class="veggie" style="left:5%; animation-delay:0s;">
<img src="img/tomato.png" class="veggie" style="left:70%; animation-delay:2s;">
<img src="img/broccoli.png" class="veggie" style="left:40%; animation-delay:1s;">

<div class="container">
    <h2>🥘 VeggieDelights Signup</h2>

    <form action="signups.php" method="POST" enctype="multipart/form-data">

        <input type="text" class="input-field" name="name" placeholder="Full Name" required>

        <input type="email" class="input-field" name="email" placeholder="Email Address" required>

        <label style="float:left;color:#444;margin-top:10px;">Profile Picture:</label>
        <input type="file" class="input-field" style="padding:10px;" name="profile_pic" accept="image/*" onchange="showPreview(event)">
        <img id="previewImg">

        <!-- Password -->
        <div class="password-box">
            <input type="password" class="input-field" id="password" name="password" placeholder="Password" required>
            <span class="toggle-eye" onclick="togglePassword('password')">👁</span>
        </div>

        <div id="strengthBar"><div id="strength"></div></div>

        <!-- Confirm Password -->
        <div class="password-box">
            <input type="password" class="input-field" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            <span class="toggle-eye" onclick="togglePassword('confirm_password')">👁</span>
        </div>

        <p id="matchMsg" class="match-msg"></p>

        <!-- Security -->
        <select name="security_question" required>
            <option value="">Select your security question</option>
            <option>What is your favorite vegetable?</option>
            <option>What city were you born in?</option>
            <option>What is your pet’s name?</option>
        </select>

        <input type="text" class="input-field" name="security_answer" placeholder="Security Answer" required>

        <!-- Captcha -->
        <label><b>Solve: <?= $num1 ?> + <?= $num2 ?> = ?</b></label>
        <input type="number" class="input-field" name="captcha" placeholder="Enter answer" required>

        <button class="btn" type="submit">Create Account</button>

        <!-- LOGIN BUTTON -->
        <a href="login.php" style="text-decoration:none;">
            <button type="button" class="login-btn">Already have an account? Login</button>
        </a>

    </form>
</div>

<script>
function togglePassword(id) {
    let field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}

function showPreview(event) {
    let output = document.getElementById('previewImg');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display = "block";
}

// Password strength bar
document.getElementById("password").addEventListener("input", function () {
    let val = this.value;
    let strength = document.getElementById("strength");

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[@$!%*#?&]/.test(val)) score++;

    let widths = ["10%", "25%", "50%", "75%", "100%"];
    let colors = ["red", "orange", "yellow", "#90ee90", "green"];

    strength.style.width = widths[score];
    strength.style.background = colors[score];
});

// Confirm password
document.getElementById("confirm_password").addEventListener("input", checkMatch);

function checkMatch() {
    let pass = document.getElementById("password").value;
    let cpass = document.getElementById("confirm_password").value;
    let msg = document.getElementById("matchMsg");

    if (cpass.length === 0) msg.innerHTML = "";
    else if (pass === cpass) {
        msg.style.color = "green";
        msg.innerHTML = "✔ Passwords match";
    } else {
        msg.style.color = "red";
        msg.innerHTML = "✘ Passwords do not match";
    }
}
</script>

</body>
</html>
