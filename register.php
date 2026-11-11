<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require 'config.php';

$email = trim($_POST['email'] ?? '');
$plain = $_POST['password'] ?? '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($email === '' || $plain === '') {
    $message = 'Email and password are required.';
  } else {
    $hash = password_hash($plain, PASSWORD_DEFAULT);

    mysqli_execute_query(
      $conn,
      'INSERT INTO users (email, password_hash) VALUES (?, ?)', [$email, $hash]
    );

    $message = 'Account created successfully.';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

  <article class="accounthead">
    <h1>Create Account</h1>
</article>
    

    <?php if ($message !== '') { ?>
    <p>
      <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>
  <?php } ?>

  <section class="account">
    <form method="POST">

    <div>
      <label for="email">Email</label>

      <input type="email" id="email" name="email" required>
    </div>

    <div>
      <label for="password">Password</label>

      <input type="password" id="password" name="password" required>
    </div>

    <button type="submit">Create Account</button>
  </form>
  </section>

  <div class="lognav">
    <a href="login.php">Go to Log In</a>
    <a href="index.php">Back</a>
  </div>

  



</body>
</html>