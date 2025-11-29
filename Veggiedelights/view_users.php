<?php
session_start();
include 'config.php'; // Your DB connection

// Get user role and email from session
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Users | Veggiedelights</title>
<style>
/* ---------- General Styling ---------- */
body { font-family: Arial, sans-serif; background:#f0f0f0; margin:0; padding:0; }
.main-content { max-width: 1000px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

/* ---------- Navbar Styling ---------- */
header.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color:#ff7b00;
    padding:10px 20px;
    flex-wrap: wrap;
}
header.navbar .logo a { font-size: 1.5rem; font-weight: bold; color:#fff; text-decoration:none; }
header.navbar nav { display:flex; gap:15px; flex-wrap: wrap; align-items: center; }
header.navbar nav a { color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition: 0.3s;font-weight:bold; }
header.navbar nav a:hover { background:#fff; color:#ff7b00; }
header.navbar nav .dropdown { position: relative; display: inline-block; }
header.navbar nav .dropdown-content {
    display: none;
    position: absolute;
    background:#fff;
    min-width:180px;
    box-shadow:0 2px 6px rgba(0,0,0,0.2);
    z-index: 1;
}
header.navbar nav .dropdown-content a {
    display:block;
    padding:10px 15px;
    color:#333;
    text-decoration:none;
}
header.navbar nav .dropdown:hover .dropdown-content { display:block; }
header.navbar nav .dropdown-content a:hover { background:#ff7b00; color:#fff; }

/* ---------- Auth Links ---------- */
.auth-links { display:flex; align-items:center; gap:10px; flex-wrap: wrap; }
.auth-links .welcome { color:#fff; font-weight:bold; }
.auth-links .nav-link {
    background:#fff;
    color:#ff7b00;
    padding:5px 10px;
    border-radius:5px;
    text-decoration:none;
    transition:0.3s;
}
.auth-links .nav-link:hover { background:#ff7b00; color:#fff; }

/* ---------- Table Styling ---------- */
.table-container { overflow-x:auto; margin-top:20px; }
table { width:100%; border-collapse:collapse; min-width:700px; }
table th, table td { padding:12px; border:1px solid #ddd; text-align:left; }
table th { background:#ff7b00; color:#fff; position: sticky; top:0; }
table tr:nth-child(even) { background:#f9f9f9; }
table tr:hover { background:#f1f1f1; }
.action-link { color:#fff; padding:5px 8px; border-radius:4px; text-decoration:none; margin-right:5px; font-size:0.9em; }
.delete-link { background:red; }
.action-link:hover { opacity:0.8; }

/* ---------- Responsive Navbar ---------- */
@media screen and (max-width:768px) {
    header.navbar { flex-direction:column; align-items:flex-start; gap:10px; }
    header.navbar nav { justify-content:flex-start; }
}
</style>
</head>
<body>

<!-- ---------- Navbar ---------- -->
<header class="navbar">
    <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
    <nav>
        <a href="index.php">Home</a>
        

        <?php if ($role === 'user'): ?>
            <a href="about.php">About</a> 
            <a href="category.php">Categories</a>
            <a href="contact.php">Contact</a>
            <a href="feedback.php">Feedback</a>
            <a href="my_recipes.php">My recipes</a>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
                    <a href="manage_categories.php">Manage Categories</a>
                    <a href="view_contact.php">Manage Contact</a>
                    <a href="view_feedback.php">Manage Feedback</a>
                    <a href="view_recipes.php">Manage Recipes</a>
                    <a href="view_users.php">Manage Users</a>
        <?php endif; ?>
    </nav>
    <div class="auth-links">
        <?php if ($role === 'admin'): ?>
            <span class="welcome">👋 Hello Admin</span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php elseif ($role === 'user'): ?>
            <span class="welcome">👋 Hello <?php echo htmlspecialchars($email); ?></span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a>
        <?php endif; ?>
    </div>
</header>

<!-- ---------- Users Table ---------- -->
<div class="main-content">
    <h1>Registered Users</h1>

    <div class="table-container">
        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>security_question</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = 1;
                $users_query = "SELECT * FROM signup ORDER BY id DESC";
                $users_rs = mysqli_query($con, $users_query);
                while($user = mysqli_fetch_array($users_rs)) {
                ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['security_question']); ?></td>
                        <td>
                            <a href="view_users.php?delete=<?php echo $user['id']; ?>" class="action-link delete-link" onclick="return confirmDelete();">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this user?");
}
</script>

</body>
</html>
