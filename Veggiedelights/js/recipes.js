const recipeForm = document.getElementById("recipeForm");
const recipesContainer = document.getElementById("recipesContainer");
const searchInput = document.getElementById("searchInput");
const recipeModal = document.getElementById("recipeModal");
const closeModal = document.getElementById("closeModal");
const modalName = document.getElementById("modalName");
const modalImage = document.getElementById("modalImage");
const modalIngredients = document.getElementById("modalIngredients");
const modalSteps = document.getElementById("modalSteps");
const editRecipeBtn = document.getElementById("editRecipeBtn");
const deleteRecipeBtn = document.getElementById("deleteRecipeBtn");

let recipes = JSON.parse(localStorage.getItem("recipes")) || [];
let currentEditIndex = null;

function saveRecipes() {
  localStorage.setItem("recipes", JSON.stringify(recipes));
}

function renderRecipes(filter = "") {
  recipesContainer.innerHTML = "";
  const filtered = recipes.filter(r => r.name.toLowerCase().includes(filter.toLowerCase()));
  filtered.forEach((recipe, index) => {
    const card = document.createElement("div");
    card.classList.add("recipe-card");
    card.innerHTML = `
      <img src="${recipe.image}" alt="${recipe.name}">
      <h3>${recipe.name}</h3>
    `;
    card.addEventListener("click", () => showRecipeModal(index));
    recipesContainer.appendChild(card);
  });
}

function showRecipeModal(index) {
  const recipe = recipes[index];
  currentEditIndex = index;
  modalName.textContent = recipe.name;
  modalImage.src = recipe.image;
  modalIngredients.innerHTML = "";
  recipe.ingredients.forEach(ing => {
    const li = document.createElement("li");
    li.textContent = ing;
    modalIngredients.appendChild(li);
  });
  modalSteps.textContent = recipe.steps;
  recipeModal.style.display = "flex";
}

closeModal.addEventListener("click", () => { recipeModal.style.display = "none"; });
window.addEventListener("click", e => { if(e.target == recipeModal) recipeModal.style.display = "none"; });

recipeForm.addEventListener("submit", e => {
  e.preventDefault();
  const name = document.getElementById("name").value.trim();
  const ingredients = document.getElementById("ingredients").value.trim().split(",").map(i => i.trim());
  const steps = document.getElementById("steps").value.trim();
  const imageFile = document.getElementById("image").files[0];

  if(!name || !ingredients.length || !steps){
    alert("Please fill all fields correctly!");
    return;
  }

  const saveRecipe = (imageData) => {
    const recipeData = {name, ingredients, steps, image: imageData};
    recipes.push(recipeData);
    saveRecipes();
    renderRecipes();
    recipeForm.reset();
  };

  if(imageFile){
    const reader = new FileReader();
    reader.onload = function(){
      const image = reader.result;
      saveRecipe(image);
    }
    reader.readAsDataURL(imageFile);
  } else if(currentEditIndex !== null) {
    const existingImage = recipes[currentEditIndex].image;
    saveRecipe(existingImage);
  } else {
    alert("Please select an image for the recipe.");
  }
});

searchInput.addEventListener("input", e => { renderRecipes(e.target.value); });

// Edit Recipe
editRecipeBtn.addEventListener("click", () => {
  if(currentEditIndex === null) return;
  const recipe = recipes[currentEditIndex];
  document.getElementById("name").value = recipe.name;
  document.getElementById("ingredients").value = recipe.ingredients.join(", ");
  document.getElementById("steps").value = recipe.steps;
  document.getElementById("image").value = "";
  recipeModal.style.display = "none";
  recipes.splice(currentEditIndex,1);
  saveRecipes();
  renderRecipes();
  currentEditIndex = null;
});

// Delete Recipe
deleteRecipeBtn.addEventListener("click", () => {
  if(currentEditIndex === null) return;
  if(confirm("Are you sure you want to delete this recipe?")){
    recipes.splice(currentEditIndex,1);
    saveRecipes();
    renderRecipes();
    recipeModal.style.display = "none";
    currentEditIndex = null;
  }
});

renderRecipes();
