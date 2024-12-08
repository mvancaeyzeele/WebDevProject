<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 24th, 2024
    Description: Final Project select page

****************/

include("header.php");
require('connect.php');
$townPostId = filter_input(INPUT_GET, 'townPostId', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM townPost WHERE townPostId = :townPostId LIMIT 1";
$statement = $db->prepare($query);
$statement->bindValue('townPostId', $townPostId, PDO::PARAM_INT);
$statement->execute();
$row = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Posting</title>
</head>
<body>
    <?php if($row): ?>
        <br>
    <h2><?php echo $row['title']?></h2>
        <br>
        <?php echo $row['description'] ?>
    <?php endif ?>
    <form method="post" action="index.php">
        <br>
        <button type="submit">Back</button>

</body>
</html>