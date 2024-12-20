<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: December 7th, 2024
    Description: Final Project edit page

****************/
include("header.php");
require('connect.php');
require('authenticate.php');

$townPostId = filter_input(INPUT_GET, 'townPostId', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM townPost WHERE townPostId = :townPostId LIMIT 1";
$statement = $db->prepare($query);
$statement->bindValue(':townPostId', $townPostId, PDO::PARAM_INT);
$statement->execute();
$row = $statement->fetch();

$itemIdQuery = "SELECT `itemId`, `itemName` FROM `item`";
$itemIdStatement = $db->prepare ($itemIdQuery);
$itemIdStatement->execute();
$items = $itemIdStatement->fetchAll(PDO::FETCH_ASSOC);

$categoryIdQuery = "SELECT `categoryId`, `category` FROM `category`";
$categoryIdStatement = $db->prepare($categoryIdQuery);
$categoryIdStatement->execute();
$categories = $categoryIdStatement->fetchAll(PDO::FETCH_ASSOC);

// Message displayed if no post found
if (!$townPostId) {
    echo "Invalid or missing post ID.";
    exit;
}

// Message displayed if no row found
if(!$row) {
    echo "Post cannot be found.";
    exit;
}

if($_POST){
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $itemId = filter_input(INPUT_POST, 'itemName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "UPDATE townPost SET title = :title, description = :description, itemId = :itemId, categoryId =:categoryId WHERE townPostId = :townPostId";
    $statement = $db->prepare($query);

    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':itemId', $itemId, type: PDO::PARAM_INT);
    $statement->bindValue(':townPostId', $townPostId, type: PDO::PARAM_INT);
    $statement->bindValue(':categoryId', $categoryId, type: PDO::PARAM_INT);

    if($statement->execute()){
        header(header: "Location: admin.php?townPostId=$townPostId");
        exit();
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
    <title>Edit Post</title>
</head>
<body>
    <div id="content">
        <h2>Edit Post</h2>
        <form method="post">
            <label for="title">Title:</label>
            <input id="title" name="title" value="<?= $row['title']?>">
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="15" cols="50" ><?= $row['description']?></textarea>
            <br>
            <input type="hidden" name="townPostId" value="<?= $row['townPostId']?>">
            <label for="itemName">Item:</label>
            <select id="itemName" name="itemName">
                <option value="">Select Item</option>
                <?php foreach ($items as $item): ?>
                    <option value="<?= htmlspecialchars($item['itemId']) ?>"
                        <?= ($item['itemId'] == $row['itemId']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($item['itemName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="categoryId">Category:</label>
            <select id="categoryId" name="categoryId" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['categoryId']) ?>"
                <?= ($category['categoryId'] == $row['categoryId']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['category']) ?>    
            </option>
                <?php endforeach; ?>
            </select>
            <br>
            <br>
            <button type="submit" name="update">Update</button>
        </form>
        <br>
        <form method="post" action="delete.php?=<?php echo $townPostId ?>">
                <input type="hidden" name="townPostId" value="<?= $row['townPostId']?>">
                <button type="submit" name="delete">Delete</button>
        </form>
        <form method="post" action="admin.php">
            <br>
            <button type="submit">Back</button>
        </form>
    </div>
</body>
</html>