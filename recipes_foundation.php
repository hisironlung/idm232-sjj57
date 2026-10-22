<?php 
  declare(strict_types=1);

    function post_value(string $key): string {
        return trim($_POST[$key] ?? '');
    }

    function e(string $value): string {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    function find_recipe(mysqli $conn, int $id): ?array {
        $sql = 'SELECT * FROM recipes WHERE id = ?';
        $result = mysqli_execute_query($conn, $sql, [$id]);
        return mysqli_fetch_assoc($result);
    }

    function all_recipes(mysqli $conn): array {
        $result = mysqli_query($conn, 'SELECT * FROM recipes ORDER BY title');
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function create_recipe(mysqli $conn, string $title, int $category_id): int {
        $sql = 'INSERT INTO recipes (title, category_id) VALUES (?, ?)';
        mysqli_execute_query($conn, $sql, [$title, $category_id]);
        return (int) mysqli_insert_id($conn);
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
        category_id INT NOT NULL,
        servings INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $result = mysqli_query($conn, $sql);*/

    $result = mysqli_query($conn, 'SELECT * FROM recipes');
    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($recipes as $recipe) {
        echo $recipe['title'] . '<br>';
    }



?>