// ===== Validation Functions =====
function isValidEmail(email){
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Live validation
const nameInput = document.querySelector('input[name="name"]');
const emailInput = document.querySelector('input[name="email"]');
const subjectInput = document.querySelector('input[name="subject"]');
const messageInput = document.querySelector('textarea[name="message"]');

const nameHint = document.getElementById('nameHint');
const emailHint = document.getElementById('emailHint');
const subjectHint = document.getElementById('subjectHint');
const messageHint = document.getElementById('messageHint');

nameInput.addEventListener('input', ()=>{
    const val = nameInput.value.trim();
    if(val.length >= 2){
        nameHint.textContent = "✔ Looks good";
        nameHint.className = "hint valid";
    } else {
        nameHint.textContent = "Name must be at least 2 characters";
        nameHint.className = "hint invalid";
    }
});

emailInput.addEventListener('input', ()=>{
    if(isValidEmail(emailInput.value.trim())){
        emailHint.textContent = "✔ Valid email";
        emailHint.className = "hint valid";
    } else {
        emailHint.textContent = "Enter a valid email";
        emailHint.className = "hint invalid";
    }
});

subjectInput.addEventListener('input', ()=>{
    if(subjectInput.value.trim().length > 0){
        subjectHint.textContent = "✔ Looks good";
        subjectHint.className = "hint valid";
    } else {
        subjectHint.textContent = "Subject cannot be empty";
        subjectHint.className = "hint invalid";
    }
});

messageInput.addEventListener('input', ()=>{
    if(messageInput.value.trim().length >= 10){
        messageHint.textContent = "✔ Looks good";
        messageHint.className = "hint valid";
    } else {
        messageHint.textContent = "Message must be at least 10 characters";
        messageHint.className = "hint invalid";
    }
});

// Form submission
document.getElementById('contactForm').addEventListener('submit', async (e)=>{
    e.preventDefault();
    const form = e.target;
    const formMsg = document.getElementById('formMsg');

    // Final validation before submission
    if(nameInput.value.trim().length < 2 ||
       !isValidEmail(emailInput.value.trim()) ||
       subjectInput.value.trim() === "" ||
       messageInput.value.trim().length < 10){
        formMsg.style.color = 'red';
        formMsg.textContent = "Please fix the errors above before submitting!";
        return;
    }

    const formData = new FormData(form);
    try{
        const res = await fetch('api/save_contact.php',{
            method:'POST',
            body: formData
        });
        const data = await res.json();
        formMsg.style.color = data.success ? 'green' : 'red';
        formMsg.textContent = data.msg;
        if(data.success) form.reset();
        // Clear hints
        nameHint.textContent = "";
        emailHint.textContent = "";
        subjectHint.textContent = "";
        messageHint.textContent = "";
    } catch(err){
        formMsg.style.color = 'red';
        formMsg.textContent = 'Server error!';
    }
});