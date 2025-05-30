<?php
session_start();
$valid_username = "Jeevan123";
$valid_password = "Noob3";
if (!isset($_SESSION['login_attempts'])) 
{
    $_SESSION['login_attempts'] = 0;
}
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($username === $valid_username && $password === $valid_password) 
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