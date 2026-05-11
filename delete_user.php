<?php
session_start();
require "connection.php";
require "csrf.php";

// Only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized");
}

// Validate CSRF
if (!validate_csrf($_POST['csrf_token'])) {
    exit("Invalid CSRF token");
}

$user_id = intval($_POST['user_id']);

// Prevent deleting yourself
if ($user_id == $_SESSION['user_id']) {
    exit("You cannot delete yourself.");
}

// Prevent deleting admins
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if ($role === "admin") {
    exit("You cannot delete another admin.");
}

// Delete user
$delete = $conn->prepare("DELETE FROM users WHERE id = ?");
$delete->bind_param("i", $user_id);
$delete->execute();

header("Location: view_users.php");
exit();
?>
