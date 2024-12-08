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
<h2>Page Administration</h2>
<a href="post.php">New Posting</a>
<div id="sort"> 
    <form method="GET" action="admin.php">
        <label for="sortBy">Sort by:</label>
        <select name="sortBy" id="sortBy" onchange="this.form.submit()">
            <option value="datePosted" <?= $sortBy === 'datePosted' ? 'selected' : '' ?>>Date Posted</option>
            <option value="title" <?= $sortBy === 'title' ? 'selected' : '' ?>>Title</option>
            <option value="name" <?= $sortBy === 'name' ? 'selected' : '' ?>>Name</option>
        </select>
    </form>
</div>

<?php while($row = $statement->fetch()): ?>
    <ul>
        <li><a href="select.php?townPostId=<?= htmlspecialchars($row['townPostId']) ?>"><?= htmlspecialchars($row['title']) ?></a></li>
        <li><?= htmlspecialchars($row['description']) ?></li>
        <li><?= htmlspecialchars($row['name']) ?></li>
        <li><?= htmlspecialchars($row['datePosted']) ?></li>
        <li><a href="edit.php?townPostId=<?= htmlspecialchars($row['townPostId']) ?>">Edit</a></li>
    </ul>
<?php endwhile; ?>
</body>
</html>