<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 30th, 2024
    Description: Final Project index page

****************/
include("header.php");
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
    <p>Welcome to the online Pelican Town Bulletin Board system. </p>
    <?php while($row = $statement->fetch()):?>
            <ul>
            <li><a href="select.php?townPostId=<?php echo $row['townPostId']; ?>"><?= $row['title']; ?></a></li>
            <li><?= $row['description']?></li>
            <li><?= $row['name']?></li> 
            </ul>
        <?php endwhile ?>
</body>
</html>