<?php
require 'connection.php';
session_start();

// Only allow logged-in admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $price       = $_POST['price'];
    $description = trim($_POST['description']);

    // Strong PHP validation
    if (empty($title) || empty($author) || empty($price)) {
        $message = "All fields except description are required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $message = "Price must be a positive number.";
    } else {

        // Insert book using prepared statement
        $stmt = $conn->prepare("INSERT INTO books (title, author, price, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $title, $author, $price, $description);

        if ($stmt->execute()) {
            $message = "Book added successfully!";
        } else {
            $message = "Error adding book.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Add New Book — BookSphere</title>
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

/* FORM CONTAINER */
.container {
    max-width: 600px;
    margin: 4rem auto;
    background: #ffffff;
    padding: 2.5rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #1f2937;
    margin-bottom: 2rem;
}

/* INPUTS */
input, textarea {
    width: 100%;
    padding: 0.9rem;
    margin-bottom: 1.2rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
}

textarea {
    height: 120px;
    resize: none;
}

/* BUTTON */
.btn {
    width: 100%;
    padding: 0.9rem;
    background: #3b5998;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
}

.btn:hover {
    background: #2f477a;
}

/* MESSAGE */
.msg {
    text-align: center;
    color: green;
    margin-bottom: 1rem;
    font-weight: 600;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<header>
    <div class="logo">Book<span>Sphere</span></div>

    <nav>
        <a href="view_books.php">Books</a>
        <a href="admin.php">Admin Panel</a>
        <a href="logout.php" style="color:#dc3545;">Logout</a>
    </nav>
</header>

<!-- FORM -->
<div class="container">
    <h2>Add New Book</h2>

    <?php if (!empty($message)): ?>
        <div class="msg"><?= $message ?></div>
    <?php endif; ?>

    <form action="add_book.php" method="POST" onsubmit="validateForm(event)">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="number" step="0.01" name="price" placeholder="Price (USD)" required>
        <textarea name="description" placeholder="Book Description (optional)"></textarea>
        <button class="btn">Add Book</button>
    </form>
</div>

<script>
function validateForm(event) {
    const title  = document.querySelector("input[name='title']");
    const author = document.querySelector("input[name='author']");
    const price  = document.querySelector("input[name='price']");

    if (title.value.trim() === "" || author.value.trim() === "" || price.value.trim() === "") {
        alert("All fields except description are required.");
        event.preventDefault();
        return false;
    }

    if (isNaN(price.value) || Number(price.value) <= 0) {
        alert("Price must be a positive number.");
        event.preventDefault();
        return false;
    }
}
</script>

</body>
</html>
