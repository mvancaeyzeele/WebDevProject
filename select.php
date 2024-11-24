<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 24th, 2024
    Description: Final Project select page

****************/

require('connect.php');
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM townpost WHERE townpostid = :townpostid LIMIT 1";
$statement = $db->prepare($query);
$statement->bindValue('townpostid', $townpostid, PDO::PARAM_INT);
$statement->execute();
$row = $statement->fetch();

// Format date
$timestamp = $row['date_posted'];
$formattedDate = date("F d, Y, h:i a", strtotime($timestamp));
$statement->bindValue('date_posted', $formattedDate);

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
    <h1>Pelican Town Bulletin Board</h1>
    <a href="index.php">Home</a>
    <a href="post.php">New Posting</a>
    <?php if($row): ?>
        <br>
    <h2><?php echo $row['title']?></h2>
        <br>
        <?php echo $row['description'] ?>
    <?php endif ?>
    <form method="post "action="index.php">
        <br>
        <?php echo $formattedDate?>
        <br>
    <li><a href="edit.php?id=<?php echo $row['id']?>"> edit</a></li>
        <br>
        <button type="submit">Back</button>

</body>
</html>