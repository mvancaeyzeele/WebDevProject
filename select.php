<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 24th, 2024
    Description: Final Project select page

****************/

include("header.php");
require('connect.php');
$townPostId = filter_input(INPUT_GET, 'townPostId', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT townPost.*, item.*
            FROM townPost 
            LEFT JOIN item ON townPost.itemId = item.itemId
            LEFT JOIN person ON townPost.personId = person.personId
            WHERE townPost.townPostId = :townPostId
            LIMIT 1";
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
    <div id ="content">
        <?php if($row): ?>
            <br>
            <h2><?= $row['title']?></h2>
            <br>
            <?= $row['description'] ?>
            <br>
            <?= "Item needed: " . $row['itemName']?>
        <?php endif ?>
        <?php if ($row['image']): ?>
            <p class="img"><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['itemName']); ?>"></p>
        <?php endif; ?>
        <form method="post" action="index.php">
            <br>
            <button type="submit">Back</button>
        </form>
    </div>
</body>
</html>