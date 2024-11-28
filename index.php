<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 24th, 2024
    Description: Final Project index page

****************/

require('connect.php');
$query = "SELECT * FROM townpost ORDER BY townpostid ASC LIMIT 5";
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
    <h1>Pelican Town Bulletin Board</h1>
    <a href="index.php">Home</a>
    <a href="post.php">New Posting</a>
    
    <p>Welcome to the online Pelican Town Bulletin Board system. </p>
    <?php while($row = $statement->fetch()):?>
            <ul>
            <li><a href="select.php?id=<?php echo $row['townpostid']; ?>"><?= $row['title']; ?></a></li>
            <li><?= $row['description'], $row['townpostid']?></li>
            <li><a href="edit.php?id=<?php echo $row['townpostid']; ?>"> edit</a></li>
            </ul>
        <?php endwhile ?>
</body>
</html>