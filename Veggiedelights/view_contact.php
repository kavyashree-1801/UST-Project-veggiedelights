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
<title>View Contacts | Veggiedelights</title>
<style>
/* ---------- General Styling ---------- */
body {
    font-family: Arial, sans-serif;
    background:#f0f0f0;
    margin:0;
    padding-top:70px; /* space for fixed navbar */
}

/* ---------- Navbar Styling ---------- */
header.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: normal;
    align-items: center;
    background-color:#ff7b00;
    padding:10px 20px;
    z-index: 1000;
    flex-wrap: wrap;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
header.navbar .logo a {
    font-size: 1.5rem;
    font-weight: bold;
    color:#fff;
    text-decoration:none;
    white-space: nowrap;
}
.nav-links {
    display:flex;
    gap:15px;
    flex-wrap: wrap;
    align-items:center;
}
.nav-links a {
    color:#fff;
    text-decoration:none;
    padding:5px 10px;
    border-radius:5px;
    font-weight:bold;
    transition:0.3s;
    white-space: nowrap;
}
.nav-links a:hover, .nav-links a.active {
    background:#fff;
    color:#ff7b00;
}

/* Auth section aligned right */
.auth-right {
    display:flex;
    align-items:center;
    gap:10px;
    flex-shrink:0;
    white-space: nowrap;
}
.auth-right .welcome { color:#fff; font-weight:bold; }
.auth-right .nav-link {
    background:#fff;
    color:#ff7b00;
    padding:5px 10px;
    border-radius:5px;
    text-decoration:none;
    transition:0.3s;
}
.auth-right .nav-link:hover { background:#ff7b00; color:#fff; }

/* ---------- Table Styling ---------- */
.main-content {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.table-container { overflow-x:auto; margin-top:10px; }
table { width:100%; border-collapse:collapse; min-width:700px; }
table th, table td { padding:12px; border:1px solid #ddd; text-align:left; }
table th { background:#ff7b00; color:#fff; position: sticky; top:0; }
table tr:nth-child(even) { background:#f9f9f9; }
table tr:hover { background:#f1f1f1; }
.action-link { color:#fff; padding:5px 8px; border-radius:4px; text-decoration:none; margin-right:5px; font-size:0.9em; }
.read-link { background:green; }
.delete-link { background:red; }
.action-link:hover { opacity:0.8; }

/* ---------- Search Box Above Table ---------- */
#searchContainer {
    text-align: right;
    margin-bottom: 10px;
}
#searchInput {
    padding:5px 10px;
    border-radius:4px;
    border:1px solid #ccc;
    width: 250px;
}

/* ---------- Responsive Navbar ---------- */
@media screen and (max-width:768px) {
    header.navbar { flex-direction: column; align-items: flex-start; gap:8px; }
    .nav-links { flex-wrap: wrap; gap:8px; width:100%; }
    .auth-right { width:100%; gap:8px; margin-top:5px; }
    #searchInput { width:100%; margin-top:5px; }
}
</style>
</head>
<body>

<!-- ---------- Navbar ---------- -->
<header class="navbar">
    <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>

    <nav class="nav-links">
        <a href="index.php">Home</a>

        <?php if ($role === 'user'): ?>
            <a href="about.php">About</a>
            <a href="category.php">Categories</a>
            <a href="contact.php">Contact</a>
            <a href="my_recipes.php">My Recipes</a>
            <a href="feedback.php">Feedback</a>
        <?php elseif ($role === 'admin'): ?>
            <a href="manage_categories.php">Manage Categories</a>
            <a href="view_contact.php" class="active">Manage Contact</a>
            <a href="view_feedback.php">Manage Feedback</a>
            <a href="view_recipes.php">Manage Recipes</a>
            <a href="view_users.php">Manage Users</a>
        <?php endif; ?>
    </nav>

    <div class="auth-right">
        <?php if ($role === 'admin'): ?>
            <span class="welcome">👋 Hello Admin</span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php elseif ($role === 'user'): ?>
            <span class="welcome">👋 Hello <?= htmlspecialchars($email) ?></span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
        <?php endif; ?>
    </div>
</header>

<!-- ---------- Contacts Table ---------- -->
<div class="main-content">
    <h1>Contact Messages</h1>

    <!-- Search Box Above Table -->
    <div id="searchContainer">
        <input type="text" id="searchInput" placeholder="Search contacts..." />
    </div>

    <div class="table-container">
        <table id="contactsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = 1;
                $fet = "SELECT * FROM contact_messages ORDER BY status ASC, id DESC";
                $fet_rs = mysqli_query($con, $fet);
                while($fet_arr = mysqli_fetch_array($fet_rs)) {
                ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo htmlspecialchars($fet_arr['name']); ?></td>
                        <td><?php echo htmlspecialchars($fet_arr['email']); ?></td>
                        <td><?php echo htmlspecialchars($fet_arr['subject']); ?></td>
                        <td><?php echo htmlspecialchars($fet_arr['message']); ?></td>
                        <td>
                            <?php if($fet_arr['status'] == 0) { ?>
                                <a href="view_contact.php?mark_read=<?php echo $fet_arr['id']; ?>" class="action-link read-link">Mark as Read</a>
                            <?php } ?>
                            <a href="view_contact.php?delete=<?php echo $fet_arr['id']; ?>" class="action-link delete-link" onclick="return confirmDelete();">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this contact?");
}

// Live search/filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#contactsTable tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

</body>
</html>
