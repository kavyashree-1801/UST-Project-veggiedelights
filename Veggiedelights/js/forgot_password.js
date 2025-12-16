function togglePassword(id){
    const pwd = document.getElementById(id);
    pwd.type = pwd.type === "password" ? "text" : "password";
}

const errorBox = document.getElementById("error");
const successBox = document.getElementById("success");

function getQuestion() {
    errorBox.innerText = "";
    successBox.innerText = "";

    const email = document.getElementById("email").value.trim();
    if (!email) { errorBox.innerText = "Email required"; return; }

    fetch("api/forgot_passwords.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "step=1&email=" + encodeURIComponent(email)
    })
    .then(res => res.text())
    .then(text => {
        const data = JSON.parse(text);
        if (data.success) {
            document.getElementById("step1").style.display = "none";
            document.getElementById("step2").style.display = "block";
            document.getElementById("question").innerText = data.question;
        } else {
            errorBox.innerText = data.error;
        }
    })
    .catch(()=> errorBox.innerText="Server error");
}

function resetPassword() {
    errorBox.innerText = "";
    successBox.innerText = "";

    const email = document.getElementById("email").value.trim();
    const answer = document.getElementById("answer").value.trim();
    const newPassword = document.getElementById("newPassword").value.trim();

    if (!answer || !newPassword) { errorBox.innerText="All fields required"; return; }

    fetch("api/forgot_passwords.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "step=2&email="+encodeURIComponent(email)+
              "&answer="+encodeURIComponent(answer)+
              "&newPassword="+encodeURIComponent(newPassword)
    })
    .then(res => res.text())
    .then(text => {
        const data = JSON.parse(text);
        if (data.success) {
            successBox.innerText="Password reset successfully! Redirecting...";
            setTimeout(()=>window.location.href="login.php",2000);
        } else {
            errorBox.innerText=data.error;
        }
    })
    .catch(()=>errorBox.innerText="Server error");
}