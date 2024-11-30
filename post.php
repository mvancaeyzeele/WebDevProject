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
$itemIdStatement = $db->prepare ($itemIdQuery);
$itemIdStatement->execute();
$items = $itemIdStatement->fetchAll(PDO::FETCH_ASSOC);

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
<h1>Pelican Town Bulletin Board</h1>
<a href="index.php">Home</a>
    <form method="post" action="post.php">
        <label for="title">Title</label>
        <input id="title" name="title">
        <label for="content">Content</label>
        <textarea id="content" name="content" rows="15" cols="50"></textarea>
        <label for="itemId">Item</label>
        <select id="itemId" name="itemId">
            <option value="">Select Item</option>
            <?php foreach ($items as $item): ?>
                <option value="<?= htmlspecialchars($item['itemId']) ?>">
                    <?= htmlspecialchars($item['itemName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit">
    </form>
</body>
</html>