<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) 
{
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Rickroll</title></head>
<body>
<h3>YEET</h3>
<img src="https://www.icegif.com/wp-content/uploads/2023/01/icegif-162.gif" alt="Rickroll" style="width: 100%; max-width: 600px;">
<p><a href="logout.php">Logout</a></p>
</body>
</html>