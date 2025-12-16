// ===== Validation Functions =====
function isValidEmail(email){
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Live validation
const nameInput = document.querySelector('input[name="name"]');
const emailInput = document.querySelector('input[name="email"]');
const ratingSelect = document.querySelector('select[name="rating"]');
const messageInput = document.querySelector('textarea[name="message"]');

const nameHint = document.getElementById('nameHint');
const emailHint = document.getElementById('emailHint');
const ratingHint = document.getElementById('ratingHint');
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

ratingSelect.addEventListener('change', ()=>{
    if(ratingSelect.value !== ""){
        ratingHint.textContent = "✔ Selected";
        ratingHint.className = "hint valid";
    } else {
        ratingHint.textContent = "Please select a rating";
        ratingHint.className = "hint invalid";
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
document.getElementById('feedbackForm').addEventListener('submit', async (e)=>{
    e.preventDefault();

    if(nameInput.value.trim().length < 2 ||
       !isValidEmail(emailInput.value.trim()) ||
       ratingSelect.value === "" ||
       messageInput.value.trim().length < 10){
        alert("Please fix the errors above before submitting!");
        return;
    }

    const form = e.target;
    const formData = new FormData(form);
    try{
        const res = await fetch('api/save_feedback.php',{
            method:'POST',
            body: formData
        });
        const data = await res.json();
        alert(data.msg);
        if(data.success) form.reset();
        // Clear hints
        nameHint.textContent = "";
        emailHint.textContent = "";
        ratingHint.textContent = "";
        messageHint.textContent = "";
    } catch(err){
        alert('⚠ Something went wrong!');
    }
});