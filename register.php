<?php
require 'connection.php';
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Strong PHP validation
    if (empty($name) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {

        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Email already registered.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Account created successfully!";
            } else {
                $message = "Error creating account.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Register — BookSphere</title>
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

/* REGISTER CARD */
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

<!-- REGISTER CARD -->
<div class="container">
    <h2>Create Account</h2>

    <?php if (!empty($message)): ?>
        <div class="msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form action="register.php" method="POST" onsubmit="validateForm(event)">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button class="btn">Register</button>
    </form>

    <div class="link">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

<script>
function validateForm(event) {
    const name = document.querySelector("input[name='name']");
    const email = document.querySelector("input[name='email']");
    const password = document.querySelector("input[name='password']");

    if (name.value.trim() === "" || email.value.trim() === "" || password.value.trim() === "") {
        alert("All fields are required.");
        event.preventDefault();
        return false;
    }

    if (password.value.length < 6) {
        alert("Password must be at least 6 characters.");
        event.preventDefault();
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        alert("Invalid email format.");
        event.preventDefault();
        return false;
    }
}
</script>

</body>
</html>
