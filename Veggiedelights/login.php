<?php
session_start();
include 'config.php';

$error = '';
$locked = false;

// ---- LOGIN ATTEMPT CONTROL ----
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}
if (!isset($_SESSION['lock_time'])) {
    $_SESSION['lock_time'] = 0;
}

// Check lockout
if ($_SESSION['attempts'] >= 4) {
    if (time() - $_SESSION['lock_time'] < 30) {
        $locked = true;
        $error = "Too many attempts! Try again after 30 seconds.";
    } else {
        $_SESSION['attempts'] = 0;
    }
}

/*
 * CAPTCHA generation logic:
 * - Generate and store captcha nums in session only when they do not exist.
 * - Compare posted captcha to the session stored answer.
 * This prevents the "regenerate-before-check" bug.
 */
if (!isset($_SESSION['captcha_num1']) || !isset($_SESSION['captcha_num2'])) {
    $_SESSION['captcha_num1'] = rand(1, 9);
    $_SESSION['captcha_num2'] = rand(1, 9);
    $_SESSION['captcha_answer'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
}

// Pull numbers for display
$num1 = $_SESSION['captcha_num1'];
$num2 = $_SESSION['captcha_num2'];

// Handle POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$locked) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $captcha = isset($_POST['captcha']) ? intval($_POST['captcha']) : null;

    // Check captcha first
    if ($captcha === null) {
        $error = "Please solve the captcha.";
    } elseif ($captcha !== intval($_SESSION['captcha_answer'])) {
        $error = "Incorrect captcha!";
        // Optionally regenerate captcha after a failed captcha to avoid brute force:
        $_SESSION['captcha_num1'] = rand(1,9);
        $_SESSION['captcha_num2'] = rand(1,9);
        $_SESSION['captcha_answer'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
        $num1 = $_SESSION['captcha_num1'];
        $num2 = $_SESSION['captcha_num2'];
    } else {
        // captcha passed -> check credentials
        $stmt = $con->prepare("SELECT * FROM signup WHERE email = ?");
        if (!$stmt) {
            $error = "Database error: prepare failed.";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows == 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {

                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['last_login'] = date("Y-m-d H:i:s");

                    $_SESSION['attempts'] = 0;

                    // Clear captcha after success
                    unset($_SESSION['captcha_num1'], $_SESSION['captcha_num2'], $_SESSION['captcha_answer']);

                    header("Location: index.php");
                    exit();
                } else {
                    $_SESSION['attempts'] += 1;
                    if ($_SESSION['attempts'] >= 4) {
                        $_SESSION['lock_time'] = time();
                    }
                    $error = "Incorrect password!";
                    // regenerate captcha after failed login to be safe
                    $_SESSION['captcha_num1'] = rand(1,9);
                    $_SESSION['captcha_num2'] = rand(1,9);
                    $_SESSION['captcha_answer'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
                    $num1 = $_SESSION['captcha_num1'];
                    $num2 = $_SESSION['captcha_num2'];
                }
            } else {
                $error = "Email not found!";
                // regenerate captcha after failed lookup
                $_SESSION['captcha_num1'] = rand(1,9);
                $_SESSION['captcha_num2'] = rand(1,9);
                $_SESSION['captcha_answer'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
                $num1 = $_SESSION['captcha_num1'];
                $num2 = $_SESSION['captcha_num2'];
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | VeggieDelights</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
    * { box-sizing: border-box; }

    body {
        height: 100vh;
        margin: 0;
        font-family: "Poppins", sans-serif;
        background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTgPw1gmLaiX0fg4Pzd67fKO9J0nd8dsvuY54VbioU2ZtlfhuG8hcdF-BVHKEe4POSG75g&usqp=CAU') no-repeat center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    body::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.85);
        z-index: 0;
    }

    .login-container {
        position: relative;
        z-index: 2;
        width: 420px;
        max-width: 92%;
        background: white;
        padding: 36px 30px;
        border-radius: 15px;
        box-shadow: 0 6px 22px rgba(0,0,0,0.25);
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); } to { opacity:1; transform:none; }
    }

    h2 {
        text-align: center;
        color: #ff7b00;
        margin: 6px 0 18px 0;
    }

    .avatar-circle {
        width: 90px;
        height: 90px;
        background: #fff;
        border-radius: 50%;
        border: 3px solid #ff7b00;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 12px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.12);
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .avatar-letter {
        font-size: 46px;
        font-weight: 700;
        color: #ff7b00;
        display: none;
    }

    input[type="email"], input[type="password"], input[type="number"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 10px;
        border: 1.5px solid #ffa54a;
        font-size: 15px;
        box-sizing: border-box;
    }

    input:focus {
        border-color: #ff7b00;
        outline: none;
        box-shadow: 0 0 6px rgba(255,123,0,0.12);
    }

    .password-field {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        cursor: pointer;
        color: #ff7b00;
        user-select: none;
    }

    .caps-warning {
        font-size: 12px;
        color: red;
        display: none;
        margin: 4px 0 0 0;
    }

    .error {
        color: red;
        font-weight: bold;
        margin-bottom: 10px;
        animation: shake 0.3s;
        text-align: center;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }

    label.captcha-label { display:block; margin-top:8px; font-weight:600; color:#333; }

    .captcha-row { display: flex; gap: 10px; align-items: center; }
    .captcha-row input { flex:1; margin: 0; }

    button {
        width: 100%;
        padding: 13px;
        background: #ff7b00;
        border: none;
        color: white;
        font-size: 17px;
        font-weight: bold;
        border-radius: 10px;
        margin-top: 12px;
        cursor: pointer;
        transition: transform .12s;
    }

    button:active { transform: scale(.99); }

    .links {
        margin-top: 12px;
        text-align: center;
        font-size: 14px;
    }

    .links a {
        text-decoration: none;
        color: #ff7b00;
        font-weight: 600;
    }

    .remember { display:flex; align-items:center; gap:8px; margin-top:10px; font-size:14px; }

    @media (max-width:460px){
        .avatar-circle { width:74px; height:74px; }
        .avatar-letter { font-size:36px; }
    }
</style>
</head>
<body>

<div class="login-container">

    <!-- Avatar: default image shown; letter displayed when email typed -->
    <div class="avatar-circle" aria-hidden="true">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="defaultUser" alt="User">
        <span class="avatar-letter" id="avatarLetter">S</span>
    </div>

    <h2>🔒 Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" novalidate>
        <label for="email" style="display:none">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required autocomplete="username">

        <div class="password-field">
            <label for="password" style="display:none">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
            <span class="toggle-password" title="Show / Hide" onclick="togglePass()">👁</span>
        </div>

        <p id="caps" class="caps-warning">⚠ Caps Lock is ON</p>

        <!-- CAPTCHA -->
        <label class="captcha-label">Solve the math captcha</label>
        <div class="captcha-row">
            <div style="padding:10px 14px; border-radius:8px; background:#fff4e6; border:1.2px solid #ffd0a8; color:#ff7b00; font-weight:700;">
                <?= intval($num1) ?> + <?= intval($num2) ?> =
            </div>
            <input type="number" name="captcha" placeholder="Answer" required>
        </div>

        <label class="remember">
            <input type="checkbox" id="rememberMe"> Remember Me
        </label>

        <button type="submit" id="loginBtn" <?= $locked ? 'disabled' : '' ?>>Login</button>

        <div class="links">
            <a href="signup.php">Create Account</a> &nbsp;·&nbsp;
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </form>
</div>

<script>
// Show/hide password
function togglePass() {
    const p = document.getElementById("password");
    p.type = p.type === "password" ? "text" : "password";
}

// Caps Lock detection
document.getElementById("password").addEventListener("keyup", function(e){
    document.getElementById("caps").style.display =
        e.getModifierState && e.getModifierState("CapsLock") ? "block" : "none";
});

// Avatar change based on email typing
const emailField = document.getElementById("email");
const imgDefault = document.getElementById("defaultUser");
const avatarLetter = document.getElementById("avatarLetter");

function updateAvatarFromEmail(val){
    const trimmed = (val || "").trim();
    if (trimmed.length > 0) {
        imgDefault.style.display = "none";
        avatarLetter.style.display = "flex";
        avatarLetter.textContent = trimmed.charAt(0).toUpperCase();
    } else {
        imgDefault.style.display = "block";
        avatarLetter.style.display = "none";
    }
}

emailField.addEventListener("input", (e) => {
    updateAvatarFromEmail(e.target.value);
    // Save to localStorage if Remember is checked (logic below will manage)
    if (document.getElementById('rememberMe').checked) {
        localStorage.setItem('savedEmail', e.target.value);
    }
});

// Remember Me localStorage
const remember = document.getElementById("rememberMe");
if (localStorage.getItem("savedEmail")) {
    emailField.value = localStorage.getItem("savedEmail");
    remember.checked = true;
    updateAvatarFromEmail(emailField.value);
}

remember.addEventListener("change", () => {
    if (remember.checked) {
        localStorage.setItem("savedEmail", emailField.value);
    } else {
        localStorage.removeItem("savedEmail");
    }
});

// Keep avatar updated if page loaded with email filled (rare case)
updateAvatarFromEmail(emailField.value);
</script>

</body>
</html>
