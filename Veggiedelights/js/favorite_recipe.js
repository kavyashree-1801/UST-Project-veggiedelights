// Load favorites
async function loadFavorites(){
    const container = document.getElementById('favContainer');
    container.innerHTML = 'Loading...';

    try{
        const res = await fetch('api/get_favorites.php');
        const data = await res.json();

        if(!data.success || data.recipes.length===0){
            container.innerHTML = '<p style="text-align:center;">No favorites yet.</p>';
            return;
        }

        container.innerHTML = '';
        data.recipes.forEach(r=>{
            const div = document.createElement('div');
            div.className = 'recipe-card';
            div.innerHTML = `
                <span class="heart favorited" data-id="${r.id}">♥</span>
                <img src="${r.image}" alt="${r.name}">
                <h3>${r.name}</h3>
                <p>${r.description}</p>
            `;
            container.appendChild(div);
        });

        // Heart click
        document.querySelectorAll('.heart').forEach(h=>{
            h.onclick = async ()=> {
                const id = h.dataset.id;
                const res = await fetch('api/toggle_favorite.php',{
                    method:'POST',
                    headers:{'Content-Type':'application/x-www-form-urlencoded'},
                    body:'recipe_id='+id
                });
                const result = await res.text();
                if(result==='removed'){
                    h.parentElement.remove();
                }
            };
        });

    }catch(err){
        container.innerHTML = '<p style="text-align:center; color:red;">Error loading favorites.</p>';
    }
}

// Initial load
loadFavorites();