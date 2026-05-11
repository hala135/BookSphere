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
<title>About the Platform — BookSphere</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #3b5998;
    --accent: #6c63ff;
    --dark: #1f2937;
    --muted: #6b7280;
    --bg: #f7f9fc;
}

body {
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
    margin: 0;
    padding: 0;
    color: var(--dark);
}

/* NAVBAR */
header {
    padding: 1.2rem 8%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
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
}

nav a:hover {
    color: var(--primary);
}

/* CONTENT */
.container {
    max-width: 900px;
    margin: 3rem auto;
    background: white;
    padding: 2.5rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

h1 {
    color: var(--primary);
    margin-bottom: 1rem;
}

h2 {
    margin-top: 2rem;
    color: var(--dark);
}

p, ul {
    color: var(--muted);
    line-height: 1.7;
}

ul {
    margin-top: 1rem;
}

/* FOOTER */
footer {
    text-align: center;
    padding: 1rem;
    color: var(--muted);
    margin-top: 3rem;
}
</style>
</head>

<body>

<header>
    <div class="logo">Book<span>Sphere</span></div>

    <nav>
        <a href="index.php">Home</a>
        <a href="view_books.php">Books</a>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php else: ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">Admin Panel</a>
            <?php endif; ?>
            <a href="logout.php" style="color:#dc3545;">Logout</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <h1>About BookSphere</h1>

    <p>
        BookSphere is a secure and structured online bookstore platform designed to provide users with 
        authenticated access to a curated collection of books, while offering administrators a dedicated 
        interface for managing book records. The platform emphasizes security, usability, and clean 
        architectural design.
    </p>

    <h2>Platform Workflow</h2>
    <p>
        The system follows a clear and intuitive workflow:
    </p>
    <ul>
        <li>Visitors can explore the platform and learn about its features.</li>
        <li>Users must create an account and log in to access the book catalog.</li>
        <li>Authenticated users can browse available books and view detailed descriptions.</li>
        <li>Administrators gain access to an Admin Panel for adding and managing books.</li>
        <li>Navigation dynamically adapts based on user role and login status.</li>
    </ul>

    <h2>Security & Architecture</h2>
    <p>
        BookSphere is built using the LAMP stack and implements:
    </p>
    <ul>
        <li>Secure authentication and session handling</li>
        <li>Role-based access control (RBAC)</li>
        <li>Prepared statements to prevent SQL injection</li>
        <li>Output sanitization to prevent XSS attacks</li>
        <li>Security headers to protect against clickjacking and MIME sniffing</li>
    </ul>

    <h2>Technologies Used</h2>
    <ul>
        <li><strong>PHP</strong> — backend logic and server-side processing</li>
        <li><strong>MySQL</strong> — structured database storage</li>
        <li><strong>Apache</strong> — web server environment</li>
        <li><strong>HTML/CSS</strong> — frontend structure and styling</li>
        <li><strong>JavaScript</strong> — client-side validation and UI enhancements</li>
    </ul>
</div>

<footer>
    BookSphere — Online Bookstore Platform
</footer>

</body>
</html>
