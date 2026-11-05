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
    </header>

    <section id="input">
        <form action="add_recipe.php" method="post" id="recipedata">
            <div>
                <label for="recipe">Recipe Name</label>
                <input type="text" id="recipe" name="recipe" required/>
            </div id="category">
                
            <div>
                <label for="category">Recipe Category</label>
                <input type="text" id="category" name="category" required/>
            </div>
            
            <div id="servings">
                <label for="servings">Recipe Servings</label>
                <input type="number" id="servings" name="servings" required/>
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


        <?php
            $recipe = '';
            $category = '';
            $servings = 0;
            $steps = [];
            $errors = [];
            $success = false;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $recipe = trim($_POST['recipe'] ?? '');
                    $category = trim($_POST['category'] ?? '');
                    $servings = trim($_POST['servings'] ?? '');
                    $steps = trim($_POST['step'] ?? '');
            
                if ($recipe === '') {
                    $errors[] = 'Recipe name is required.';
                }

                if ($category === '') {
                    $errors[] = 'Recipe category is required.';
                }

                if ($servings === 0) {
                    $errors[] = 'Recipe servings are required.';
                }

                if (empty($steps)){
                    $errors[] = 'At least one step is required.';
                }

                if (empty($errors)) {
                    $success = true;
                }
            }
        ?>

        <?php if (!empty($errors)):

        foreach ($errors as $error): ?> 
          <p id="errors"> <?php echo ($error) ?> </p>
        <?php endforeach; 
        endif;

        if ($success === true): ?>
            <h4> <?php echo 'Recipe Submitted' ?> </h4>
            <p>You added: <?php echo ($recipe) ?> </p>
            <p>Category: <?php echo ($category) ?> </p>
            <p>Servings: <?php echo ($servings) ?> </p>
            <p>Steps: <?php foreach ($steps as $step): ?> 
                 <?php echo ($step) ?>
                <?php endforeach; ?> </p>
        <?php endif; ?>

    </section>

    <script src="add_recipe.js"></script>
</body>
</html>