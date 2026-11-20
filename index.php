<?php 
  declare(strict_types=1);

  ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookbook</title>
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

        <?php if (isset($_SESSION['user_id'])) { ?>
            <div>
                <a href="edit_recipe.php">Edit Recipes</a>
            </div>
                
        <?php } ?>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <div>
                <a href="account.php">Account</a>
            </div>
                
        <?php } 
        else{?>
            <div>
                <a href="account.php"><h4>Log In</h4></a>
            </div>
        <?php }?>
    </header>

    </section>

    <?php

    $search = trim($_GET['search'] ?? '');
    $category = (int) ($_GET['category'] ?? 0);

    if ($search !== '' && $category > 0) {

    $result = mysqli_execute_query(
        $conn,
        'SELECT *
         FROM recipes
         WHERE title LIKE ?
         AND category_id = ?',
        ['%' . $search . '%', $category]
    );

    } elseif ($search !== '') {

        $result = mysqli_execute_query(
            $conn,
            'SELECT *
            FROM recipes
            WHERE title LIKE ?',
            ['%' . $search . '%']
        );

    } elseif ($category > 0) {

        $result = mysqli_execute_query(
            $conn,
            'SELECT *
            FROM recipes
            WHERE category_id = ?',
            [$category]
        );

    } else {

        $result = mysqli_execute_query(
            $conn,
            'SELECT *
            FROM recipes'
        );

    }

    $recipes = mysqli_fetch_all(
            $result, MYSQLI_ASSOC
        );

    ?>


    <section id="searchform">

        <form action="index.php" method="get" id="searchbar">

            <input type="text" id="search" name="search" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="category">Filter</label>

            <select name="category" id="category">
                <option value="">All Categories</option>
                <option value="1" <?php if ($category === 1) echo 'selected'; ?>>Chicken</option>
                <option value="2" <?php if ($category === 2) echo 'selected'; ?>>Beef</option>
                <option value="3" <?php if ($category === 3) echo 'selected'; ?>>Pork</option>
                <option value="4" <?php if ($category === 4) echo 'selected'; ?>>Turkey</option>
                <option value="5" <?php if ($category === 5) echo 'selected'; ?>>Seafood</option>
                <option value="6" <?php if ($category === 6) echo 'selected'; ?>>Vegetarian</option>
            </select>


            <button type="submit">Search</button>

        </form>
        

    </section>

    <section id="results">

    <?php if (empty($recipes)): ?>

        <p>No recipes found.</p>

    <?php else: ?>

        <div class="recipesgrid">

            <?php foreach ($recipes as $recipe): ?>

                <a
                    href="recipe.php?id=<?php echo (int) $recipe['id']; ?>"
                    class="recipe"
                >

                    <h2>
                        <?php
                        echo htmlspecialchars(
                            $recipe['title'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </h2>

                    <h3>
                        <?php
                        echo htmlspecialchars(
                            $recipe['subtext'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </h3>

                    <div class="recipeimage">

                        <img
                            src="<?php echo htmlspecialchars(
                                $recipe['image'],
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                            alt="<?php echo htmlspecialchars(
                                $recipe['title'],
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                    </div>

                </a>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>


<footer>
    <article>
        <div>
            <h1>
                <a href="index.php">Kellin's Cookbook</a>
            </h1>
        </div>

    <div>
        <h1>IDM 232</h1>
    </div>
    </article>
    

    <?php if (isset($_SESSION['user_id'])) { ?>
        <div>
            <a href="edit_recipe.php">Edit Recipes</a>
        </div>
                
    <?php } ?>

    <?php if (isset($_SESSION['user_id'])) { ?>
        <div>
            <a href="account.php">Account</a>
        </div>
                
    <?php } else{?>
        <div>
            <a href="account.php"><h4>Log In</h4></a>
        </div>
    <?php }?>
</footer>

    


</body>

</html>