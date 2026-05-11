<?php
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Only allow logged-in admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Detect current page to hide Admin Panel button
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Admin Dashboard — BookSphere</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #f5f7fa;
}

/* NAVBAR */
header {
    background: #ffffff;
    padding: 1rem 8%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
}

.logo {
    font-weight: 700;
    font-size: 1.4rem;
    color: #3b5998;
}

nav a {
    margin-left: 1.5rem;
    text-decoration: none;
    color: #6b7280;
    font-weight: 500;
}

nav a:hover {
    color: #3b5998;
}

/* DASHBOARD */
.container {
    max-width: 900px;
    margin: 3rem auto;
    background: white;
    padding: 2.5rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #1f2937;
    margin-bottom: 2rem;
}

.section {
    display: flex;
    justify-content: space-between;
    gap: 2rem;
}

.card {
    flex: 1;
    background: #f9fafb;
    padding: 1.8rem;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: center;
}

.card h3 {
    color: #3b5998;
    margin-bottom: 1rem;
}

.btn {
    display: inline-block;
    padding: 0.8rem 1.4rem;
    background: #3b5998;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    margin-top: 0.5rem;
}

.btn:hover {
    background: #2f477a;
}

.btn-alt {
    background: #6c63ff;
}

.btn-alt:hover {
    background: #5a52d6;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<header>
    <div class="logo">Book<span>Sphere</span></div>

    <nav>
        <a href="view_books.php">Books</a>

        <?php if ($current_page !== "admin.php"): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>

        <a href="logout.php" style="color:#dc3545;">Logout</a>
    </nav>
</header>

<!-- DASHBOARD -->
<div class="container">
    <h2>Admin Dashboard</h2>

    <div class="section">

        <!-- Manage Books -->
        <div class="card">
            <h3>Manage Books</h3>
            <a href="add_book.php" class="btn">Add Book</a>
            <a href="view_books.php" class="btn btn-alt">View Books</a>
        </div>

        <!-- Manage Users -->
        <div class="card">
            <h3>Manage Users</h3>
            <a href=" view_users.php" class="btn btn-alt">View Users</a>
        </div>

    </div>
</div>

</body>
</html>
