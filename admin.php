<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: December 6th, 2024
    Description: Admin main page

****************/
require('authenticate.php');
require('connect.php');

$validSortColumns = ['datePosted', 'title', 'name']; 
$sortBy = filter_input(INPUT_GET, 'sortBy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!in_array($sortBy, $validSortColumns)) {
    $sortBy = 'datePosted';
}

$query = "SELECT townPost.*, person.name 
          FROM townPost
          JOIN person ON townPost.personId = person.personId
          ORDER BY $sortBy ASC";
$statement = $db->prepare($query);
$statement->execute();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Pelican Town Bulletin Board</title>
</head>
<body>
<?php include('header.php'); ?>
<br>
<div id="content">
    <h2>Page Administration</h2>
    <a href="post.php">New Posting</a>
    <a href="categoryPost.php">New Category</a>
    <a href="imageUpload.php">Upload Image</a>
    <br>
    <br>
    <form method="GET" action="admin.php">
        <label for="sortBy">Sort by:</label>
        <select name="sortBy" id="sortBy" onchange="this.form.submit()">
            <option value="datePosted" <?= $sortBy === 'datePosted' ? 'selected' : '' ?>>Date Posted</option>
            <option value="title" <?= $sortBy === 'title' ? 'selected' : '' ?>>Title</option>
            <option value="name" <?= $sortBy === 'name' ? 'selected' : '' ?>>Name</option>
        </select>
    </form>


    <?php while($row = $statement->fetch()): ?>
        <ul>
            <ul><a href="select.php?townPostId=<?= htmlspecialchars($row['townPostId']) ?>"><?= htmlspecialchars($row['title']) ?></a></ul>
            <ul><?= htmlspecialchars($row['description']) ?></ul>
            <ul><?= htmlspecialchars($row['name']) ?></ul>
            <ul><?= htmlspecialchars($row['datePosted']) ?></ul>
            <ul><a href="edit.php?townPostId=<?= htmlspecialchars($row['townPostId']) ?>">Edit</a></ul>
        </ul>
    <?php endwhile; ?>
</div>
</body>
</html>