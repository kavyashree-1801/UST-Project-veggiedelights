<?php
session_start();
include 'config.php';

/* ===================== ADMIN PROTECTION ===================== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'] ?? 'Admin';

/* ===================== DELETE USER ===================== */
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // Prevent deleting admin users
    $check = mysqli_query($con, "SELECT role FROM signup WHERE id=$delete_id");
    $row = mysqli_fetch_assoc($check);

    if ($row && $row['role'] !== 'admin') {
        mysqli_query($con, "DELETE FROM signup WHERE id=$delete_id");
        header("Location: view_users.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users | Veggiedelights</title>

<style>
/* ---------- GENERAL ---------- */
body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background: #f4f4f4;
}

/* ---------- NAVBAR ---------- */
header.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ff7b00;
    padding: 12px 20px;
    flex-wrap: wrap;
}

header.navbar .logo a {
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold;
    text-decoration: none;
}

header.navbar nav {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

header.navbar nav a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 5px;
    transition: 0.3s;
}

header.navbar nav a:hover {
    background: #fff;
    color: #ff7b00;
}

.auth-links {
    display: flex;
    gap: 10px;
    align-items: center;
}

.auth-links .welcome {
    color: #fff;
    font-weight: bold;
}

.auth-links .nav-link {
    background: #fff;
    color: #ff7b00;
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.auth-links .nav-link:hover {
    background: #ff7b00;
    color: #fff;
}

/* ---------- CONTENT ---------- */
.main-content {
    max-width: 1100px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.main-content h1 {
    text-align: center;
    color: #ff7b00;
    margin-bottom: 20px;
}

/* ---------- TABLE ---------- */
.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background: #ff7b00;
    color: #fff;
}

table tr:nth-child(even) {
    background: #f9f9f9;
}

table tr:hover {
    background: #f1f1f1;
}

.delete-btn {
    background: red;
    color: #fff;
    padding: 6px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
}

.delete-btn:hover {
    opacity: 0.8;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
    header.navbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>
</head>

<body>

<!-- ===================== NAVBAR ===================== -->
<header class="navbar">
    <div class="logo">
        <a href="index.php">🥘 Veggiedelights</a>
    </div>

    <nav>
        <a href="index.php">Home</a>
        <a href="manage_categories.php">Manage Categories</a>
        <a href="view_contact.php">Manage Contact</a>
        <a href="view_feedback.php">Manage Feedback</a>
        <a href="view_recipes.php" class="active">Manage Recipes</a>
        <a href="view_users.php">Manage Users</a>
    </nav>

    <div class="auth-links">
        <span class="welcome">👋 Hello Admin</span>
        <a href="logout.php" class="nav-link">Logout</a>
    </div>
</header>

<!-- ===================== USERS TABLE ===================== -->
<div class="main-content">
    <h1>Registered Users</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Security Question</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $query = "SELECT * FROM signup WHERE role != 'admin' ORDER BY id DESC";
                $result = mysqli_query($con, $query);

                while ($user = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= htmlspecialchars($user['name']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['security_question']); ?></td>
                    <td>
                        <a class="delete-btn"
                           href="view_users.php?delete=<?= $user['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this user?');">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
