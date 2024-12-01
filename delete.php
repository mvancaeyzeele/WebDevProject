<?php

/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 30th, 2024
    Description: CRUD

****************/
require('connect.php');
require('authenticate.php');

$id = filter_input(INPUT_POST, 'townPostId', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM townPost WHERE townPostId = :townPostId LIMIT 1";
    $statement = $db->prepare($query);
    $statement->bindValue(':townPostId', $townPostId, type: PDO::PARAM_INT);
    $statement->execute();
header("Location: index.php");
exit();
?>