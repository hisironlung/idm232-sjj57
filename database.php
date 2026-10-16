<?php
declare(strict_types=1);

function post_value(string $key): string {
        return trim($_POST[$key] ?? '');
    }

function e(string $value): string {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

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

/*$sql = "
  CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(120) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )
";
$result = mysqli_query($conn, $sql);*/

/*$sql = "
  INSERT INTO recipes (title, description)
  VALUES (
    'Ancho-Orange Chicken',
    'with Kale Rice & Roasted Carrots'
  )
";
mysqli_query($conn, $sql);

$sql = "
  INSERT INTO recipes (title, description)
  VALUES (
    'Beef Medallions & Mushroom Sauce',
    'with Mashed Potatoes'
  )
";
mysqli_query($conn, $sql);*/


/*$result = mysqli_query(
  $conn,
  'SELECT * FROM recipes WHERE id = 1'
);
$recipe = mysqli_fetch_assoc($result);
echo $recipe['title'];*/

$result = mysqli_query($conn, 'SELECT * FROM recipes');
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($recipes as $recipe) {
  echo $recipe['title'] . '<br>';
}


?>

