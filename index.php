<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: December 12th, 2024
    Description: Final Project index page

****************/
include("header.php");
require('connect.php');

$categoryId = filter_input(INPUT_GET, 'sortBy', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT townPost.*, person.name
        FROM townPost
        INNER JOIN person ON townPost.personId = person.personId";
if ($categoryId) {
    $query .= " WHERE townPost.categoryId = $categoryId";
}
$query .= " ORDER BY townPost.datePosted DESC";


$statement = $db->prepare($query);
$statement->execute();
// Stop errors from displaying
ini_set('display_errors', 0); 

$categoryIdQuery = "SELECT `categoryId`, `category` FROM `category`";
$categoryIdStatement = $db->prepare($categoryIdQuery);
$categoryIdStatement->execute();
$categories = $categoryIdStatement->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <ulnk rel="stylesheet" href="main.css">
    <title>Pelican Town Bulletin Board</title>
</head>
<body>
    <div id ="content">
        <h2>Welcome to the online Pelican Town Bulletin Board system. </h2>
        <form method="GET" action="index.php">
            <label for="sortBy">Sort by category:</label>
            <select name="sortBy" id="sortBy" onchange="this.form.submit()">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['categoryId']) ?>">
                        <?= htmlspecialchars($category['category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        

        <?php while($row = $statement->fetch()): ?>
        <ul>
            <ul><a href="select.php?townPostId=<?= htmlspecialchars($row['townPostId']) ?>"><?= htmlspecialchars($row['title']) ?></a></ul>
            <ul><?= htmlspecialchars($row['description']) ?></ul>
            <ul>Posted By: <?= htmlspecialchars($row['name']) ?></ul>
            <ul>Date Posted: <?= htmlspecialchars($row['datePosted']) ?></ul>
            <ul><a href="edit.php?townPostId=<?= htmlspecialchars($row['townPostId']) ?>">Edit</a></ul>
        </ul>
        <?php endwhile; ?>
    </div>
</body>
</html>