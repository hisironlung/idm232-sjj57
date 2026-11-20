<?php
declare(strict_types=1);

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



session_start();

require 'config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: account.php');
  exit;
}


$errors = [];
$success = isset($_GET['deleted']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $recipe_id = (int) ($_POST['recipe_id'] ?? 0);

  if ($recipe_id <= 0) {
    $errors[] = 'Please select a recipe.';
  }

  if (empty($errors)) {
    mysqli_execute_query(
      $conn,
      'DELETE FROM recipes WHERE id = ?',
      [$recipe_id]
    );

    header('Location: delete_recipe.php?deleted=1');
    exit;
  }
}

$recipes_result = mysqli_execute_query(
  $conn,
  'SELECT id, title
   FROM recipes
   ORDER BY title'
);

$recipes = mysqli_fetch_all(
  $recipes_result,
  MYSQLI_ASSOC
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Recipes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <div>
            <a href="index.php"><h1>Kellin's Cookbook</h1></a>
        </div>

        <div>
            <h1>IDM 232</h1>
        </div>

        <div>
            <a href="edit_recipe.php"><h4>Edit Recipes</h4></a>
        </div>

        <div>
            <a href="account.php"><h4>Log In</h4></a>
        </div>
    </header>

    <article class="functionheader">
        <h1>Delete a Recipe</h1>
    </article>

    <section id="delete">

        <form action="delete_recipe.php" method="post" class="recipemenu">
            <label for="recipe_id">Select Recipe</label>

            <select name="recipe_id" id="recipe_id">

                <option value="">Choose a Recipe</option>

                <?php foreach ($recipes as $recipe): ?>
                    <option value="<?php echo (int) $recipe['id']; ?>">
                        <?php
                        echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8');
                        ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Delete Recipe</button>

        </form>

    </section>

    <?php if (!empty($errors)): ?>

            <?php foreach ($errors as $error): ?>
                <p class="errors">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            <?php endforeach; ?>

        <?php endif; ?>


    <?php if ($success === true): ?>

        <h4>Recipe Deleted!</h4>
    <?php endif; ?>


</body>
</html>