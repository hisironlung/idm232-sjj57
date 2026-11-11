<?php 
  declare(strict_types=1);
  
  require 'config.php';
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
    <?php
    
    $recipes_result = mysqli_execute_query(
        $conn,
        'SELECT id, title FROM recipes ORDER BY title'
    );

    $recipes = mysqli_fetch_all($recipes_result, MYSQLI_ASSOC);
    
    
    ?>



    <?php

    $errors = [];
    $success = false;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $recipe_id = (int) ($_POST['recipe_id'] ?? 0);

        if ($recipe_id <= 0) {
            $errors[] = 'Please select a recipe.';
        }

        if (empty($errors)) {
            mysqli_execute_query(
                $conn, 'DELETE FROM recipes WHERE id = ?', [$recipe_id]
        );

            $success = true;
        }

    }

    ?>

    

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
            <a href="search_recipe.php"><h4>Search Recipes</h4></a>
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