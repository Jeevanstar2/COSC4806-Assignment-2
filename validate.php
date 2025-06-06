<?php
session_start();
require 'db.php';
if (!isset($_SESSION['login_attempts'])) 
{
    $_SESSION['login_attempts'] = 0;
}
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$stmt = $pdo->prepare("SELECT * FROM COSC4806001_Assignment2_Users WHERE Username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
if ($user && password_verify($password, $user['Password'])) 
{
    $_SESSION['authenticated'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['login_attempts'] = 0;
    header("Location: index.php");
    exit();
} 
else 
{
    $_SESSION['login_attempts'] += 1;
    $error_message = "Login Failed. Attempts: " . $_SESSION['login_attempts'];
    header("Location: login.php?error=" . urlencode($error_message));
    exit();
}
?>