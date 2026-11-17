<?php
declare(strict_types=1);

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div>
            <h1>
                <a href="index.php">Kellin's Cookbook</a>
            </h1>
        </div>

        <div>
            <h1>IDM 232</h1>
        </div>
    </header>



    <div id="login">
        <div>
            <a href="register.php">Create an Account</a>
        </div>
        
        <div>
            <a href="login.php">Log In</a>
        </div>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <div>
                <a href="logout.php">Log Out</a>
            </div>
                
        <?php } ?>
        
    </div>

    <div class="lognav">
        <a href="index.php">Back</a>
    </div>
    
</body>
</html>