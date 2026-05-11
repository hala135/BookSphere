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
<title>Get Started — BookSphere</title>
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

p {
    color: var(--muted);
    line-height: 1.7;
}

.steps {
    margin-top: 2rem;
}

.step-box {
    background: #eef2ff;
    padding: 1.2rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    border-left: 5px solid var(--primary);
}

.step-box h3 {
    margin: 0 0 0.5rem 0;
    color: var(--primary);
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
    <h1>Get Started</h1>

    <p>
        This guide walks you through the essential steps to begin using BookSphere. 
        Whether you're a new user exploring the platform or an administrator managing book records, 
        the workflow is simple, secure, and intuitive.
    </p>

    <div class="steps">

        <div class="step-box">
            <h3>1. Create an Account</h3>
            <p>
                Register by providing your name, email, and password. 
                All credentials are securely hashed and stored.
            </p>
        </div>

        <div class="step-box">
            <h3>2. Login to Your Account</h3>
            <p>
                Use your registered email and password to log in. 
                The system validates your credentials and establishes a secure session.
            </p>
        </div>

        <div class="step-box">
            <h3>3. Browse Available Books</h3>
            <p>
                Once logged in, you can access the full book catalog. 
                Each book includes a detailed description accessible through a secure popup interface.
            </p>
        </div>

        <div class="step-box">
            <h3>4. Admin Features (For Administrators)</h3>
            <p>
                Administrators gain access to the Admin Panel, where they can add new books, 
                manage existing entries, and oversee platform content.
            </p>
        </div>

        <div class="step-box">
            <h3>5. Logout</h3>
            <p>
                When you're done, simply log out to securely end your session.
            </p>
        </div>

    </div>
</div>

<footer>
    BookSphere — Online Bookstore Platform
</footer>

</body>
</html>
