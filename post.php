<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 30th, 2024
    Description: Final Project post page

****************/
include("header.php");
require('connect.php');
require('authenticate.php');

$itemIdQuery = "SELECT `itemId`, `itemName` FROM `item`";
$itemIdStatement = $db->prepare($itemIdQuery);
$itemIdStatement->execute();
$items = $itemIdStatement->fetchAll(PDO::FETCH_ASSOC);

$personIdQuery = "SELECT `personId`, `name` FROM `person`";
$personIdStatement = $db->prepare($personIdQuery);
$personIdStatement->execute();
$people = $personIdStatement->fetchAll(PDO::FETCH_ASSOC);

$categoryIdQuery = "SELECT `categoryId`, `category` FROM `category`";
$categoryIdStatement = $db->prepare($categoryIdQuery);
$categoryIdStatement->execute();
$categories = $categoryIdStatement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $itemId = filter_input(INPUT_POST, 'itemId', FILTER_SANITIZE_NUMBER_INT);
    $personId = filter_input(INPUT_POST, 'personId', FILTER_SANITIZE_NUMBER_INT);
    $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);

    if ($title && $content && $itemId) {
        $query = "INSERT INTO townPost (personId, itemId, title, description, datePosted, categoryId) VALUES (:personId, :itemId, :title, :description, NOW(), :categoryId)";
        $statement = $db->prepare($query);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $content);
        $statement->bindValue(':itemId', $itemId, PDO::PARAM_INT);
        $statement->bindValue(':personId', $personId, PDO::PARAM_INT);
        $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);

        if ($statement->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            $error = "Error inserting the post.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>New Post</title>
</head>
<body>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post" action="post.php">
    <label for="title">Title</label>
    <input id="title" name="title" required>
    <label for="content">Content</label>
    <textarea id="content" name="content" rows="15" cols="50" required></textarea>
    <label for="itemId">Item:</label>
    <select id="itemId" name="itemId" required>
        <option value="">Select Item:</option>
        <?php foreach ($items as $item): ?>
            <option value="<?= htmlspecialchars($item['itemId']) ?>">
                <?= htmlspecialchars($item['itemName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <label for="personId">Person:</label>
    <select id="personId" name="personId" required>
        <option value="">Select Name</option>
        <?php foreach ($people as $person): ?>
            <option value="<?= htmlspecialchars($person['personId']) ?>">
                <?= htmlspecialchars($person['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="categoryId">Category:</label>
    <select id="categoryId" name="categoryId" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['categoryId']) ?>">
                <?= htmlspecialchars($category['category']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Create Post">
</form>
</body>
</html>