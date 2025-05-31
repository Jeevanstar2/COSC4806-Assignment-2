<?php
require 'db.php';
$error_message = '';
$username = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    if (empty($username) || empty($password) || empty($confirm_password)) 
    {
        $error_message = "All fields are required.";
    }
    elseif (strlen($password) < 8) 
    {
        $error_message = "Password must be at least 8 characters long.";
    }
    elseif (!preg_match('/[A-Z]/', $password)) 
    {
        $error_message = "Password must contain at least one uppercase letter.";
    }
    elseif (!preg_match('/[0-9]/', $password)) 
    {
        $error_message = "Password must contain at least one number.";
    }
    elseif ($password !== $confirm_password) 
    {
        $error_message = "Passwords do not match. Please try again.";
    }
    else 
    {
        $stmt = $pdo->prepare("SELECT * FROM COSC4806001_Assignment2_Users WHERE Username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) 
        {
            $error_message = "Username already exists. Please choose a different one.";
        } 
        else 
        {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO COSC4806001_Assignment2_Users (Username, Password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed_password])) 
            {
                header("Location: login.php?success=" . urlencode("Account created successfully. Please log in."));
                exit();
            } 
            else 
            {
                $error_message = "Error creating account. Please try again.";
            }
        }
    }
}
?>
<h2>Create a New Account</h2>
<?php if (!empty($error_message)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<form method="POST">
    Username: <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Confirm Password: <input type="password" name="confirm_password" required><br><br>
    <button type="submit">Register</button>
</form>
<p><a href="login.php">Back to Login</a></p>