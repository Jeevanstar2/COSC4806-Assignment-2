<?php
require 'db.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    if (empty($username) || empty($password) || empty($confirm_password)) 
    {
        die("All fields are required.");
    }
    if (strlen($password) < 8) 
    {
        die("Password must be at least 8 characters long.");
    }
    if (!preg_match('/[A-Z]/', $password)) 
    {
        die("Password must contain at least one uppercase letter.");
    }
    if (!preg_match('/[0-9]/', $password)) 
    {
        die("Password must contain at least one number.");
    }
    if ($password !== $confirm_password) 
    {
        die("Passwords do not match. Please try again.");
    }
    $stmt = $pdo->prepare("SELECT * FROM COSC4806001_Assignment2_Users WHERE Username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) 
    {
        die("Username already exists. Please choose a different one.");
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO COSC4806001_Assignment2_Users (Username, Password) VALUES (?, ?)");
    if ($stmt->execute([$username, $hashed_password])) 
    {
        echo "Account created successfully. <a href='login.php'>Login here</a>.";
    } 
    else 
    {
        echo "Error creating account. Please try again.";
    }
}
?>
<h2>Create a New Account</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Confirm Password: <input type="password" name="confirm_password" required><br><br>
    <button type="submit">Register</button>
</form>