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