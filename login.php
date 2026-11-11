<?php
declare(strict_types=1);

session_start();

require 'config.php';

$email = trim($_POST['email'] ?? '');
$plain = $_POST['password'] ?? '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($email === '' || $plain === '') {
    $error = 'Email and password are required.';
  } else {
    $result = mysqli_execute_query(
      $conn,
      'SELECT id, email, password_hash FROM users WHERE email = ?',  [$email]
    );

    $user = mysqli_fetch_assoc($result);

    if (
      $user &&
      password_verify($plain, $user['password_hash'])
    ) {
      session_regenerate_id(true);

      $_SESSION['user_id'] = $user['id'];
      $_SESSION['email'] = $user['email'];

      header('Location: admin.php');
      exit;
    }

    $error = 'Invalid email or password.';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<article class="accounthead">
    <h1>Log In</h1>
</article>
    
    <?php if ($error !== '') { ?>
    <p>
      <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </p>
  <?php } ?>


  <section class="account">
    <form method="POST" >
    <div>
      <label for="email">Email</label>

      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
      <label for="password">Password</label>

      <input
        type="password"
        id="password"
        name="password"
        required
      >
    </div>

    <button type="submit">Log In</button>
  </form>
  </section>
    
  <div class="lognav">
    <a href="index.php">Back</a>
  </div>
  


</body>
</html>