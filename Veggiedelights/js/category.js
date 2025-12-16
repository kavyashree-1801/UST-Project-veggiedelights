const container = document.getElementById('categoryContainer');

async function loadCategories(){
    container.innerHTML = 'Loading categories...';
    try {
        // Correct path to get_categories.php
        const res = await fetch('api/get_categories.php');
        const data = await res.json();

        if(!data.success || !data.categories || data.categories.length===0){
            container.innerHTML = '<p style="text-align:center;">No categories found.</p>';
            return;
        }

        container.innerHTML = '';
        data.categories.forEach(cat=>{
            const card = document.createElement('div');
            card.className = 'category-card';
            card.innerHTML = `
                <img src="${cat.image}" alt="${cat.name}">
                <h2>${cat.name}</h2>
                <a href="category_recipes.php?cat=${encodeURIComponent(cat.name)}" class="btn">View Recipes</a>
            `;
            container.appendChild(card);
        });
    } catch(e){
        console.error(e);
        container.innerHTML = '<p style="text-align:center;">Error loading categories.</p>';
    }
}

loadCategories();