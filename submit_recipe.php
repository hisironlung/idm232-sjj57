<?php 
  declare(strict_types=1);

    function post_value(string $key): string {
        return trim($_POST[$key] ?? '');
    }

    function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $name = '';
    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
    
        if ($name === '') {
            $errors[] = 'Recipe name is required.';
        }

        if (empty($errors)) {
            $success = true;
        }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="submit_recipe.php" method="post" required>
        <label for="name">Recipe name</label>
        <input type="text" id="name" name="name" require/>
        <button type="submit">Submit</button>
    </form>

    <?php if (!empty($errors)):?>

        <?php foreach ($errors as $error): ?>
          <p><?php echo e($error)?></p>
        <?php endforeach;?> 
    <?php endif; ?>

    <?php if ($success === true):?>
        <p><?php echo 'Recipe Submitted'?></p>
        <p>You added: <?php echo e($name)?></p>
    <?php endif; ?>

</body>
</html>



<?php
    
?>