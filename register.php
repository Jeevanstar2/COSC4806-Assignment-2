<?php
require 'db.php'; // Connect to MariaDB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check password length
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long.");
    }

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM COSC4806001_Assignment2_Users WHERE Username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        die("Username already exists. Please choose a different one.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $stmt = $pdo->prepare("INSERT INTO COSC4806001_Assignment2_Users (Username, Password) VALUES (?, ?)");
    if ($stmt->execute([$username, $hashed_password])) {
        echo "Account created successfully. <a href='login.php'>Login here</a>.";
    } else {
        echo "Error creating account. Please try again.";
    }
}
?>

<h2>Create a New Account</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>
