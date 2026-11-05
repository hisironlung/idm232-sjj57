<?php
declare(strict_types=1);

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<p>Logged in as <?php echo htmlspecialchars((string) $_SESSION['email'], ENT_QUOTES, 'UTF-8');?></p>
<a href="homepage.php">Go to Cookbook</a>
<a href="logout.php">Log out</a>

</body>
</html>