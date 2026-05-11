<?php
require 'connection.php';
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Strong PHP validation
    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {

        // Fetch user by email
        $stmt = $conn->prepare("SELECT id, name, password_hash, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {

            $stmt->bind_result($id, $name, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {

                // Create session
                $_SESSION['user_id'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;

                // Redirect based on role
                if ($role === "admin") {
                    header("Location: admin.php");
                    exit;
                } else {
                    header("Location: view_books.php");
                    exit;
                }

            } else {
                $error = "Incorrect password.";
            }

        } else {
            $error = "Email not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Login — BookSphere</title>
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

/* LOGIN CARD */
.container {
    max-width: 420px;
    margin: 5rem auto;
    background: #ffffff;
    padding: 2.5rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #1f2937;
    margin-bottom: 1.5rem;
}

label {
    font-size: 0.9rem;
    color: #444;
}

input {
    width: 100%;
    padding: 0.9rem;
    margin-top: 0.3rem;
    margin-bottom: 1.2rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
}

.btn {
    width: 100%;
    padding: 0.9rem;
    background: #3b5998;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
}

.btn:hover {
    background: #2f477a;
}

.msg {
    text-align: center;
    color: red;
    margin-bottom: 1rem;
    font-weight: 600;
}

.link {
    text-align: center;
    margin-top: 1rem;
    font-size: 0.9rem;
}

.link a {
    color: #3b5998;
    text-decoration: none;
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

<!-- LOGIN CARD -->
<div class="container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required minlength="3">

        <button class="btn">Login</button>
    </form>

    <div class="link">
        Don’t have an account? <a href="register.php">Register</a>
    </div>
</div>

</body>
</html>
