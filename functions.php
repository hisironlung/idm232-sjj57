<?php
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
?>