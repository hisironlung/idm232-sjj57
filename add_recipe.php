<?php
declare(strict_types=1);

session_start();

require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: account.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <h1>Add a Recipe</h1>
    </article>


    <section id="add">
        <form action="add_recipe.php" method="post" enctype="multipart/form-data" id="recipedata">
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
                <label for="image">Recipe Image</label>
                <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" required>
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
            $steps = [];
            $upload_folder = __DIR__ . '/assets/images/uploads/';
            $image = '';
            $errors = [];
            $success = false;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $recipe = trim($_POST['recipe'] ?? '');
                    $description = trim($_POST['description'] ?? '');
                    $subtext = trim($_POST['subtext'] ?? '');
                    $category = (int) ($_POST['category'] ?? 0);
                    $servings = (int) ($_POST['servings'] ?? 0);
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

                if (empty($steps)){
                    $errors[] = 'At least one step is required.';
                }

                if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $errors[] = 'Recipe image is required.';
                }

                if (empty($errors)) {
                    $max_bytes = 2 * 1024 * 1024;
                    if ($_FILES['image']['size'] > $max_bytes) {
                        $errors[] = 'Image must be 2 MB or smaller.';
                        }
                }

                if (empty($errors)) {
                    $finfo = new finfo(FILEINFO_MIME_TYPE);

                    $mime = $finfo->file(
                        $_FILES['image']['tmp_name']
                    );

                    $ext_map = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/webp' => 'webp',
                    ];

                    if (!isset($ext_map[$mime])) {
                        $errors[] = 'Image type is not allowed.';
                    }
                }

                if (empty($errors)) {
                    $ext = $ext_map[$mime];

                    $safe_name = bin2hex(random_bytes(16)) . '.' . $ext;
                }

                if (empty($errors)) {
                    $target = $upload_folder . $safe_name;

                    if (!move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        $target
                    )) {
                        $errors[] = 'Could not save image.';
                    }
                }

                if (empty($errors)) {
                    $image = 'assets/images/uploads/' . $safe_name;

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