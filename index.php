<?php
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>BookSphere — Online Bookstore Platform</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #3b5998;
    --accent: #6c63ff;
    --dark: #1f2937;
    --muted: #6b7280;
    --bg: #f5f7fa;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
}

/* NAVBAR */
header {
    background: #ffffff;
    padding: 1rem 8%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 10;
}

.logo {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--primary);
}

nav a {
    margin-left: 1.5rem;
    text-decoration: none;
    color: var(--muted);
    font-weight: 500;
    transition: 0.2s;
}

nav a:hover {
    color: var(--primary);
}

/* HERO SECTION */
.hero {
    max-width: 900px;
    margin: 5rem auto;
    text-align: center;
    padding: 0 2rem;
}

.hero h1 {
    font-size: 2.8rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.hero p {
    font-size: 1.15rem;
    color: var(--muted);
    margin-bottom: 2.5rem;
    line-height: 1.7;
}

/* BUTTONS */
.btn {
    display: inline-block;
    padding: 0.9rem 2rem;
    margin: 0.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s ease;
}

.btn-primary {
    background: var(--primary);
    color: #fff;
}

.btn-primary:hover {
    background: #2f477a;
}

.btn-accent {
    background: var(--accent);
    color: #fff;
}

.btn-accent:hover {
    background: #5a52d6;
}

/* FOOTER */
footer {
    text-align: center;
    margin-top: 4rem;
    padding: 1rem;
    color: var(--muted);
    font-size: 0.9rem;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<header>
    <div class="logo">Book<span>Sphere</span></div>

    <nav>
        <a href="index.php">Home</a>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="view_books.php">Books</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php else: ?>
            <a href="view_books.php">Books</a>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">Admin Panel</a>
            <?php endif; ?>

            <a href="logout.php" style="color:#dc3545;">Logout</a>
        <?php endif; ?>
    </nav>
</header>

<!-- HERO SECTION -->
<div class="hero">
    <h1>Online Bookstore Platform</h1>
    <p>
        BookSphere is a secure and structured online bookstore system designed to provide seamless access to book
        collections, user authentication, and administrative management — all built using the LAMP architecture.
    </p>
<a href="get_started.php" class="btn btn-primary">Get Started</a>
<a href="about.php" class="btn btn-accent">About the Platform</a>
</div>

<!-- FOOTER -->
<footer>
    Developed for CYS 538 — Web Technology and Security
</footer>

</body>
</html>
