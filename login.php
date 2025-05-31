<?php
session_start();
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) 
{
    header("Location: index.php");
    exit();
}
if (!isset($_SESSION['login_attempts'])) 
{
    $_SESSION['login_attempts'] = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .error-msg 
        {
            color: red;
            margin-left: 40px;
        }
    </style>
</head>
<body>
<h2>Login Page</h2>
<form action="validate.php" method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <input type="submit" value="Login">
</form>

<p>Don't have an account? <a href="register.php">Create a new account</a></p>

</body>
</html>
