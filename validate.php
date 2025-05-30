<?php
session_start();
require 'db.php'; // Connect to your MariaDB database

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Check if user exists in the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password_hash'])) {
    // Login successful
    $_SESSION['authenticated'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['login_attempts'] = 0;
    header("Location: index.php");
    exit();
} else {
    // Login failed
    $_SESSION['login_attempts'] += 1;
    $error_message = "Login Failed. Attempts: " . $_SESSION['login_attempts'];
    header("Location: login.php?error=" . urlencode($error_message));
    exit();
}
?>
