<?php
session_start();
require "connection.php";

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch books securely
$stmt = $conn->prepare("SELECT id, title, author, price, description FROM books ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

// Detect current page to hide Books button
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Available Books — BookSphere</title>
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

/* TABLE */
.container {
    max-width: 1000px;
    margin: 3rem auto;
    background: white;
    padding: 2rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #1f2937;
    margin-bottom: 2rem;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #3b5998;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
    text-align: center;
}

tr:hover {
    background: #f1f5f9;
}

/* View Description Button */
.desc-btn {
    padding: 8px 12px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.desc-btn:hover {
    background: #218838;
    transform: scale(1.05);
}

/* Popup */
#popup {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

#popupBox {
    background: white;
    padding: 25px;
    width: 420px;
    border-radius: 10px;
    text-align: center;
}

.close-btn {
    margin-top: 15px;
    padding: 8px 15px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.close-btn:hover {
    background: #c82333;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<header>
    <div class="logo">Book<span>Sphere</span></div>

    <nav>
        <?php if ($current_page !== "view_books.php"): ?>
            <a href="view_books.php">Books</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>

        <a href="logout.php" style="color:#dc3545;">Logout</a>
    </nav>
</header>

<!-- CONTENT -->
<div class="container">
    <h2>📚 Available Books</h2>

    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Description</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td>$<?= htmlspecialchars($row['price']) ?></td>
                <td>
                    <button class="desc-btn"
                        onclick="showDescription(this.dataset.desc)"
                        data-desc="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>">
                        View Description
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- POPUP -->
<div id="popup">
    <div id="popupBox">
        <h3>📘 Book Description</h3>
        <p id="popupText"></p>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>
</div>

<script>
function showDescription(text) {
    document.getElementById("popupText").innerText = text;
    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}
</script>

</body>
</html>
