<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'config.php';?>
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
        <h1>Add a Recipe</h1>
    </article>


    <section id="add">
        <form action="add_recipe.php" method="post" id="recipedata">
            <div>
                <label for="recipe">Recipe Name</label>
                <input type="text" id="recipe" name="recipe" required/>
            </div>

            <div>
                <label for="description">Recipe Description</label>
                <textarea id="description" name="description" required></textarea>
                <!--<input type="text" id="description" name="description" required/>-->
            </div>

            <div>
                <label for="subtext">Recipe Subtext</label>
                <input type="text" id="subtext" name="subtext" required/>
            </div>
                
            <div>
                <label for="category">Recipe Category</label>
                <select name="category" id="category">
                    <option value="1">Chicken</option>
                    <option value="2">Beef</option>
                    <option value="3">Pork</option>
                    <option value="4">Turkey</option>
                    <option value="5">Seafood</option>
                    <option value="6">Vegetarian</option>
                </select>
            </div>
            
            <div id="servings">
                <label for="servings">Recipe Servings</label>
                <input type="number" id="servings" name="servings" required/>
            </div>

            <div>
                <label for="image">Recipe Image URL</label>
                <input type="text" id="image" name="image" required/>
            </div>

            <div>
                    <label for="steps">Recipe Steps</label>
                    <button type="button" id="add_button">Add Step</button>
                    <button type="button" id="remove_button">Remove Step</button>
            </div>

            <div id="steps">
                
            </div>

            <div>
                <button type="submit">Submit</button>
            </div>

        </form>

        <div class="output">

            <?php
            $recipe = '';
            $description = '';
            $subtext = '';
            $category = 0;
            $servings = 0;
            $image = '';
            $steps = [];
            $errors = [];
            $success = false;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $recipe = trim($_POST['recipe'] ?? '');
                    $description = trim($_POST['description'] ?? '');
                    $subtext = trim($_POST['subtext'] ?? '');
                    $category = (int) ($_POST['category'] ?? 0);
                    $servings = (int) ($_POST['servings'] ?? 0);
                    $image = trim($_POST['image'] ?? '');
                    $steps = $_POST['steps'] ?? [];
            
                if ($recipe === '') {
                    $errors[] = 'Recipe name is required.';
                }

                if ($description === '') {
                    $errors[] = 'Recipe description is required.';
                }

                if ($subtext === '') {
                    $errors[] = 'Recipe subtext is required.';
                }

                if ($category <= 0) {
                    $errors[] = 'Recipe category is required.';
                }

                if ($servings <= 0) {
                    $errors[] = 'Recipe servings are required.';
                }

                if ($image === '') {
                    $errors[] = 'Recipe image URL is required.';
                }

                if (empty($steps)){
                    $errors[] = 'At least one step is required.';
                }

                if (empty($errors)) {
                    $result = mysqli_execute_query(
                        $conn,
                        'INSERT INTO recipes (title, description, subtext, category_id, image, servings)
                        VALUES (?, ?, ?, ?, ?, ?)',
                        [$recipe, $description, $subtext, $category, $image, $servings]
                    );

                    $success = true;
                }
            }
        ?>

        <?php if (!empty($errors)): ?>

            <?php foreach ($errors as $error): ?>
                <p class="errors">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            <?php endforeach; ?>

        <?php endif; ?>


        <?php if ($success === true): ?>

            <h3>Recipe Submitted!</h3>

            <!--<p>
                You added:
                <?php //echo htmlspecialchars($recipe, ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <p>
                Category:
                <?php //echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <p>
                Servings:
                <?php //echo htmlspecialchars((string) $servings, ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <p>Steps:</p>

            <?php //foreach ($steps as $step): ?>
                <p>
                    <?php //echo htmlspecialchars($step, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            <?php //endforeach; ?>

        <?php endif; ?>


        </div>


        

    </section>


    <script src="add_recipe.js"></script>
</body>
</html>