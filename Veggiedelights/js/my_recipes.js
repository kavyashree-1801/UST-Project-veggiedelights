// Fetch recipes from backend API
async function loadRecipes(){
    const container = document.getElementById('recipeContainer');
    container.innerHTML = '<p>Loading recipes...</p>';

    try {
        const res = await fetch('api/my_recipe.php');
        const data = await res.json();

        if(!data.success){
            container.innerHTML = `<p style="color:red;">${data.error}</p>`;
            return;
        }

        if(data.recipes.length === 0){
            container.innerHTML = '<p>No recipes added yet. 🍽️</p>';
            return;
        }

        container.innerHTML = '';
        data.recipes.forEach(recipe => {
            const card = document.createElement('div');
            card.className = 'recipe-card';
            card.innerHTML = `
                <img src="${recipe.image}" alt="${recipe.name}">
                <h2>${recipe.name}</h2>
                <p>${recipe.description.substring(0,120)}...</p>
                <button class="view-btn" onclick="viewRecipe(${recipe.id})">View Recipe</button>
                <button class="delete-btn" onclick="deleteRecipe(${recipe.id})">Delete Recipe</button>
            `;
            container.appendChild(card);
        });
    } catch(err){
        container.innerHTML = `<p style="color:red;">Server error!</p>`;
        console.error(err);
    }
}

// View recipe (redirect)
function viewRecipe(id){
    window.location.href = `recipe.php?id=${id}`;
}

// Delete recipe via API
async function deleteRecipe(id){
    if(!confirm('Are you sure you want to delete this recipe?')) return;

    const formData = new FormData();
    formData.append('id', id);

    try {
        const res = await fetch('delete_recipe.php', { method:'POST', body:formData });
        const data = await res.json();

        if(data.success){
            alert('Recipe deleted successfully!');
            loadRecipes();
        } else {
            alert('Error: ' + data.error);
        }
    } catch(err){
        alert('Server error!');
        console.error(err);
    }
}

// Initial load
loadRecipes();