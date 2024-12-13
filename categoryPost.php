<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: December 8th, 2024
    Description: Final Project Category post page

****************/
include('header.php');
require('connect.php');
require('authenticate.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCategory = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!empty($newCategory)) {
        $query = "INSERT INTO `category` (`category`) VALUES (:newCategory)";
        $statement = $db->prepare($query);
        $statement->bindValue(':newCategory', $newCategory);

        if ($statement->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            $error = "Error inserting the category.";
        }
    } else {
        $error = "Please enter a new category name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" description="IE=edge">
    <meta name="viewport" description="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Create Category</title>
</head>
<body>
    <div id="content">
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="category">New Category</label>
            <input type="text" id="category" name="category" required>
            <button type="submit">Submit</button>
        </form>
        <form method="post" action="admin.php">
            <br>
            <button type="submit">Back</button>
        </form>
    </div>
</body>
</html>