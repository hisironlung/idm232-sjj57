<?php 
  declare(strict_types=1);
  
  require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Recipes</title>
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
        <h1>Update a Recipe</h1>
    </article>




    <?php
    $errors = [];
    $success = false;
    $selected_recipe = null;

    if (isset($_POST['update_recipe'])) {
        $recipe_id = (int) ($_POST['recipe_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $category = (int) ($_POST['category'] ?? 0);
        $servings = (int) ($_POST['servings'] ?? 0);

        if ($recipe_id <= 0) {
            $errors[] = 'Invalid recipe.';
        }

        if ($title === '') {
            $errors[] = 'Recipe name is required.';
        }

        if ($category <= 0) {
            $errors[] = 'Recipe category is required.';
        }

        if ($servings <= 0) {
            $errors[] = 'Recipe servings are required.';
        }

        if (empty($errors)) {
            mysqli_execute_query(
                $conn,
                'UPDATE recipes
                SET title = ?, category_id = ?, servings = ?
                WHERE id = ?',
                [$title, $category, $servings, $recipe_id]
            );

            $success = true;
        }
    }

    if (isset($_POST['edit_recipe'])) {
    $recipe_id = (int) ($_POST['recipe_id'] ?? 0);

        if ($recipe_id > 0) {
            $result = mysqli_execute_query(
                $conn,
                'SELECT id, title, category_id, servings
                FROM recipes
                WHERE id = ?',
                [$recipe_id]
            );

            $selected_recipe = mysqli_fetch_assoc($result);
        }
    }

    $recipes_result = mysqli_execute_query(
        $conn,
        'SELECT id, title FROM recipes ORDER BY title'
    );

    $recipes = mysqli_fetch_all($recipes_result, MYSQLI_ASSOC);

    ?>

    <section id="update">

        <form action="update_recipe.php" method="post" class="recipemenu">
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

            <button type="submit" name="edit_recipe">Edit Recipe</button>

        </form>


        <?php if ($selected_recipe): ?>

        <form action="update_recipe.php" method="post" class="recipemenu">

            <input type="hidden" name="recipe_id" value="<?php echo (int) $selected_recipe['id']; ?>">

            <div>
                <label for="title">Recipe Name</label>

                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($selected_recipe['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>


            <div>
                <label for="category">Recipe Category</label>

                <select name="category" id="category">

                    <option
                        value="1"
                        <?php if ($selected_recipe['category_id'] == 1) echo 'selected'; ?>
                    >
                        Chicken
                    </option>

                    <option
                        value="2"
                        <?php if ($selected_recipe['category_id'] == 2) echo 'selected'; ?>
                    >
                        Beef
                    </option>

                    <option
                        value="3"
                        <?php if ($selected_recipe['category_id'] == 3) echo 'selected'; ?>
                    >
                        Pork
                    </option>

                    <option
                        value="4"
                        <?php if ($selected_recipe['category_id'] == 4) echo 'selected'; ?>
                    >
                        Turkey
                    </option>

                    <option
                        value="5"
                        <?php if ($selected_recipe['category_id'] == 5) echo 'selected'; ?>
                    >
                        Seafood
                    </option>

                    <option
                        value="6"
                        <?php if ($selected_recipe['category_id'] == 6) echo 'selected'; ?>
                    >
                        Vegetarian
                    </option>

                </select>
            </div>


            <div>
                <label for="servings">Recipe Servings</label>

                <input type="number" name="servings" id="servings" value="<?php echo (int) $selected_recipe['servings']; ?>" required>
            </div>


            <button type="submit" name="update_recipe">Update Recipe</button>

        </form>
        <?php endif; ?>


        <?php if ($success === true): ?>

            <h3>Recipe Updated!</h3>

        <?php endif; ?>

    </section>



</body>
</html>