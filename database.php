<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'recipes';

try {
  $conn = mysqli_connect($host, $user, $pass, $db);
  mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
  exit('Connection failed: ' . $e->getMessage());
}

$result = mysqli_query($conn, 'SELECT * FROM recipes_data');
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($recipes as $recipe) {
  echo $recipe['title'] . '<br>';
}


?>