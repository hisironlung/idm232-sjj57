<?php
declare(strict_types=1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Fallback for servers running PHP older than 8.2 (such as the school's digm
// server), where mysqli_execute_query() doesn't exist yet. It does the same
// job with older mysqli functions: prepare the SQL, bind each value to its ?,
// then run it. On PHP 8.2 and newer the real function exists, so this block
// is skipped.
if (!function_exists('mysqli_execute_query')) {
function mysqli_execute_query(mysqli $mysql, string $query, ?array $params = null): mysqli_result|bool {
// Keep the latest statement alive until the next query, so
// mysqli_affected_rows() and mysqli_insert_id() still report its result
// (closing it would reset them).
static $last_statement = null;
 

$statement = mysqli_prepare($mysql, $query);
$last_statement = $statement;
 

if ($params !== null && $params !== []) {
$types = '';
foreach ($params as $value) {
$types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
}
$values = array_values($params);
mysqli_stmt_bind_param($statement, $types, ...$values);
}
 

mysqli_stmt_execute($statement);
 

// INSERT, UPDATE and DELETE return no rows: report success with true,
// like the real function, without asking for a result.
if (mysqli_stmt_result_metadata($statement) === false) {
return true;
}
 

return mysqli_stmt_get_result($statement);
}
}



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