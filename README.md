## Veggiedelights
A recipe book web application that allows users to browse, search, add, edit, and manage vegetarian recipes with secure login, role-based access, and a clean responsive interface. Built using PHP, MySQL, HTML/CSS, and vanilla JavaScript.

## 📸 Demo / Live Link  
🔗 **Live Preview:**  

📂 **Repository Link:**

 ## Features
User signup & login with sessions
Role-based dashboard (User / Admin)
Add, update & delete recipes
Recipe detail view with ingredients & steps
Category-based browsing (desserts, starters, main course, etc.)
Search bar with live filtering
Secure prepared SQL queries
Responsive design
Image upload support

## Tech stack

| Technology          | Used For                                         |
| ------------------- | ------------------------------------------------ |
| PHP                 | Backend logic, session handling, CRUD operations |
| MySQL               | Database for storing users & recipes             |
| HTML / CSS          | Frontend structure & styling                     |
| JavaScript(vanilla) | Form validation & UI interactions                |
| PHP Sessions        | User authentication & role management            |


## Installation

Download or clone the project folder

Place files under your server directory (e.g., htdocs/veggiedelights/)

Create a MySQL database

Import the provided SQL file

Open and update config.php with DB credentials

$con = mysqli_connect("localhost", "root", "", "veggiedelights");

Run the project in browser:
http://localhost/veggiedelights

## 📁 Folder Structure
veggiedelights/
│
├── css/                     # All CSS files
├── js/                      # JavaScript files
├── api/                     # Backend API handlers (AJAX)
│
├── index.php                # Home page
├── login.php                # User login
├── signup.php               # User signup
├── logout.php               # Logout (user/admin)
│
├── userprofile.php          # User profile management
├── my_recipes.php           # User's own recipes
├── favorite_recipes.php     # Favorite recipes
├── contact.php              # Contact form
├── feedback.php             # Feedback form
├── search_recipe.php        #search recipes
├── add_recipes.php          # users recipe form
├── about.php                #about the website
│
├── manage_users.php         # Admin: Manage users
├── manage_recipes.php       # Admin: Manage all recipes
├── manage_categories.php    # Admin: Manage recipe categories
├── manage_contact.php       # Admin: View contact messages
├── manage_feedback.php      # Admin: View feedback
│
├── config.php               # Database configuration
└── README.md                # Project documentation


## 🧠 Future Improvements
Password reset via email
Multiple image upload support for recipes
Advanced search filters (ingredients, cooking time, difficulty)
Multi-language support (English, Hindi, Kannada, etc.)
Email or push notifications for new recipes
Meal planner & shopping list generator

## 📧 Contact

**Kavyashree D M **  
📩 Email: kavyashreedmmohan@gmail.com    

---

## ⭐ Support

If you like this project, please ⭐ the repo!



