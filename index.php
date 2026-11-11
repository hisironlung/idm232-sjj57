<?php 
  declare(strict_types=1);
  
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

    </section>


    <section id="functions">

        <a href="edit_recipe.php">
            <div>
                <h3>Edit Recipes</h3>
            </div>
        </a>

        <a href="search_recipe.php">
            <div>
                <h3>Search Recipes</h3>
            </div>
        </a>

    </section>

    <section id="content">

    <?php
        $sql = "SELECT * FROM recipes";
        $result = mysqli_query($conn, $sql);

        echo '<div class="recipesgrid">';

        foreach ($result as $recipe) {
            echo '<div class="recipe">';
            
            echo '<h2>' . htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '<h3>' . htmlspecialchars($recipe['subtext'], ENT_QUOTES, 'UTF-8') . '</h3>';

            echo '<div class="recipeimage">';
            
            echo '<img src="' . htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8') . '" alt="">';

            echo '</div>';

            echo '</div>';
        }
    ?>
    </section>




    


</body>

</html>