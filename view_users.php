<?php
session_start();
require "connection.php";
require "csrf.php";

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Pagination settings
$limit = 10; // 10 users per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$search_query = "%$search%";

// Count total users
$count_stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE name LIKE ? OR email LIKE ?");
$count_stmt->bind_param("ss", $search_query, $search_query);
$count_stmt->execute();
$count_stmt->bind_result($total_users);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total_users / $limit);

// Fetch users
$stmt = $conn->prepare("
    SELECT id, name, email, role, created_at 
    FROM users 
    WHERE name LIKE ? OR email LIKE ?
    ORDER BY id DESC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ssii", $search_query, $search_query, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>View Users — BookSphere</title>
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

/* CONTAINER */
.container {
    max-width: 1100px;
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

/* SEARCH BAR */
.search-box {
    text-align: right;
    margin-bottom: 1.5rem;
}

.search-box input {
    padding: 10px;
    width: 250px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
}

/* TABLE */
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

/* ACTION BUTTONS */
.delete-btn {
    padding: 8px 12px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.delete-btn:hover {
    background: #b52a37;
}

.promote-btn {
    padding: 8px 12px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.promote-btn:hover {
    background: #2563eb;
}

/* PAGINATION */
.pagination {
    text-align: center;
    margin-top: 2rem;
}

.pagination a {
    padding: 8px 14px;
    margin: 0 5px;
    background: #e5e7eb;
    border-radius: 6px;
    text-decoration: none;
    color: #374151;
}

.pagination a.active {
    background: #3b5998;
    color: white;
}

.pagination a:hover {
    background: #d1d5db;
}
</style>
</head>

<body>

<header>
    <div class="logo">Book<span>Sphere</span></div>

    <nav>
        <a href="view_books.php">Books</a>
        <a href="admin.php">Admin Panel</a>
        <a href="logout.php" style="color:#dc3545;">Logout</a>
    </nav>
</header>

<div class="container">
    <h2>👥 Registered Users</h2>

    <!-- SEARCH -->
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Search users..." value="<?= htmlspecialchars($search) ?>">
        </form>
    </div>

    <!-- TABLE -->
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars(ucfirst($row['role'])) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>

                    <!-- DELETE BUTTON -->
                    <?php if ($row['id'] != $_SESSION['user_id'] && $row['role'] !== 'admin'): ?>
                        <form action="delete_user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                            <button class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">
                                Delete
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- PROMOTE BUTTON -->
                    <?php if ($row['role'] !== 'admin'): ?>
                        <form action="promote_user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                            <button class="promote-btn" onclick="return confirm('Promote this user to admin?')">
                                Promote
                            </button>
                        </form>
                    <?php endif; ?>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- PAGINATION -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" 
               class="<?= $i == $page ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

</div>

</body>
</html>
