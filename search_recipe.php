<?php 
  declare(strict_types=1);
  
  require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Recipes</title>
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

        <form action="search_recipe.php" method="get" id="searchbar">

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

            <?php echo '<div class="recipesgrid">';

        foreach ($result as $recipe) {
            echo '<div class="recipe">';
            
            echo '<h2>' . htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '<h3>' . htmlspecialchars($recipe['subtext'], ENT_QUOTES, 'UTF-8') . '</h3>';

            echo '<div class="recipeimage">';
            
            echo '<img src="' . htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8') . '" alt="">';

            echo '</div>';

            echo '</div>';
        }?>

        <?php endif; ?>

    </section>

</body>
</html>