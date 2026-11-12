<?php
declare(strict_types=1);

require 'config.php';

$recipe_id = (int) ($_GET['id'] ?? 0);

if ($recipe_id <= 0) {
    exit('Invalid recipe.');
}

$result = mysqli_execute_query(
    $conn,
    'SELECT *
     FROM recipes
     WHERE id = ?',
    [$recipe_id]
);

$recipe = mysqli_fetch_assoc($result);

if (!$recipe) {
    exit('Recipe not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8');?></title>
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

    <section class="fullrecipe">

        <div class="maindetails">

            <div class="recipeheading">
                
                <div class="recipetitle">
                    <h1>
                        <?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8');?>
                    </h1>

                    <h2>
                        <?php echo htmlspecialchars($recipe['subtext'], ENT_QUOTES, 'UTF-8');?>
                    </h2>
                </div>

                <div class="recipedesc">
                    <p>
                        <?php echo htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8');?>
                    </p>

                    <p>
                        Servings: <?php echo (int) $recipe['servings']; ?>
                    </p>
                </div>

                <div class="recipeactions">

                    <form action="update_recipe.php" method="post">
                        <input type="hidden" name="recipe_id" value="<?php echo (int) $recipe['id']; ?>">

                        <button type="submit" name="edit_recipe">Update Recipe</button>
                    </form>


                    <form action="delete_recipe.php" method="post" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                        <input type="hidden" name="recipe_id" value="<?php echo (int) $recipe['id']; ?>">

                        <button type="submit" name="delete_recipe">Delete Recipe</button>
                    </form>

                </div>

            </div>

        

            <div class="mainimage">

                <img src="<?php echo htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">

            </div>

        </div>

        

        

    </section>

    <article>
        <a href="search_recipe.php">Return</a>
    </article>

</body>
</html>