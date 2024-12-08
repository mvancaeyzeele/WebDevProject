<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: December 6th, 2024
    Description: Admin main page

****************/
require('authenticate.php');
require('connect.php');

$townPostId = filter_input(INPUT_GET, 'townPostId', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT townPost.*, person.name 
        FROM townPost
        INNER JOIN person ON townPost.personId = person.personId
        ORDER BY townPost.datePosted DESC
        LIMIT 5";
$statement = $db->prepare($query);
$statement->execute();
// Stop errors from displaying
ini_set('display_errors', 0); 

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
<?php include('header.php')?>
<br>
    <h2>Page Administration</h2>
    <a href="post.php">New Posting</a>
    <div id="sort"> 
        <form method="GET" action="admin.php">
            <label for="sortBy">Sort by:</label>
            <select name="sortBy" id="sortBy">
                <option value="datePosted" <?= $sortBy === 'datePosted' ? 'selected' : '' ?>>Date Posted</option>
            </select>
        </form>
    </div>

    <?php while($row = $statement->fetch()):?>
            <ul>
            <li><a href="select.php?townPostId=<?php echo $row['townPostId']; ?>"><?= $row['title']; ?></a></li>
            <li><?= $row['description']?></li>
            <li><?= $row['name']?></li>
            <li><a href="edit.php?townPostId=<?php echo $row['townPostId']; ?>"> edit</a></li>
            </ul>
        <?php endwhile ?>
</body>
