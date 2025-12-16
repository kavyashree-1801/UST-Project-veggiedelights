// Function to validate URL
function isValidURL(str) {
    try {
        new URL(str);
        return true;
    } catch {
        return false;
    }
}

document.getElementById('recipeForm').addEventListener('submit', async (e)=>{
    e.preventDefault();
    const form = e.target;
    const msgBox = document.getElementById('msg');
    msgBox.textContent = '';
    msgBox.className = '';

    const name = form.name.value.trim();
    const description = form.description.value.trim();
    const ingredients = form.ingredients.value.trim();
    const steps = form.steps.value.trim();
    const image = form.image.value.trim();
    const category = form.category.value.trim();

    // ===== Front-end Validation =====
    if(!name || !description || !ingredients || !steps || !image || !category){
        msgBox.textContent = "All fields are required!";
        msgBox.className = "error-msg";
        return;
    }

    // Ingredients must contain comma
    if(!ingredients.includes(",")){
        msgBox.textContent = "Ingredients should be separated by commas!";
        msgBox.className = "error-msg";
        return;
    }

    // Steps must start with a number and dot
    const stepLines = steps.split(/\r?\n/).filter(l => l.trim() !== "");
    const stepRegex = /^\d+\.\s+/;
    for(const line of stepLines){
        if(!stepRegex.test(line)){
            msgBox.textContent = "Each step must start with a number followed by a dot, e.g., 1. Preheat oven";
            msgBox.className = "error-msg";
            return;
        }
    }

    // Image URL validation
    if(!isValidURL(image)){
        msgBox.textContent = "Please enter a valid image URL!";
        msgBox.className = "error-msg";
        return;
    }

    // ===== Send to backend =====
    const formData = new FormData(form);
    try{
        const res = await fetch('api/add_recipes.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        msgBox.textContent = data.msg;
        msgBox.className = data.success ? "success-msg" : "error-msg";
        if(data.success) form.reset();
    } catch(err){
        msgBox.textContent = "⚠ Something went wrong!";
        msgBox.className = "error-msg";
    }
});