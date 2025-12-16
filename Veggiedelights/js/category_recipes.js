// Heart toggle
document.querySelectorAll('.heart').forEach(h=>{
    h.addEventListener('click', e=>{
        e.stopPropagation();
        const id = h.dataset.id;
        fetch('api/toggle_favorites.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'recipe_id='+id
        })
        .then(res=>res.text())
        .then(res=>{
            if(res==='added') h.classList.add('favorited');
            else if(res==='removed') h.classList.remove('favorited');
            else if(res==='login_required') alert('Please login to favorite!');
            else alert(res);
        });
    });
});

// Expand card to show ingredients & steps
document.querySelectorAll('.recipe-card').forEach(card=>{
    card.addEventListener('click', ()=>{
        const content = card.querySelector('.card-content');
        content.classList.toggle('show');
    });
});