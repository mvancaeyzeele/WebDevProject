<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: December 10th, 2024
    Description: Image Upload Page

****************/
session_start();
require('connect.php');
include('header.php');

$itemIdQuery = "SELECT `itemId`, `itemName` FROM `item`";
$itemIdStatement = $db->prepare($itemIdQuery);
$itemIdStatement->execute();
$items = $itemIdStatement->fetchAll(PDO::FETCH_ASSOC);

$targetDir = "images/";
$output = "";

if(!is_dir($targetDir)) {
    mkdir($targetDir);
}

if(isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === 0) {
    $file = $_FILES['uploaded_file'];
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $itemId = filter_input(INPUT_POST, 'itemId', FILTER_SANITIZE_NUMBER_INT);

    $fileType = mime_content_type($file["tmp_name"]);
    $allowedTypes = ['image/jpeg', 'image/png'];

    if(in_array($fileType, $allowedTypes)) {
        if(move_uploaded_file($file["tmp_name"], $targetFile)) {
            try {
                $query = "UPDATE item SET image = :image WHERE itemId = :itemId";
                $statement = $db->prepare($query);
                $statement->bindValue(':itemId', $itemId, PDO::PARAM_INT);
                $statement ->bindValue(':image', $targetFile);
                $statement->execute();

                $output = "File Uploaded Successfully.";
            } catch(Exception $e) {
                $output = "Database Error:" . $e->getMessage();
            }
        }
        else {
            $output = "Error uploading file.";
        }
    }
    else {
        $output = "Invalid file type.";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Upload an image</title>
</head>
<body>
    <h2>Upload an Image for an Item</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="itemId">Item:</label>
        <select id="itemId" name="itemId" required>
            <option value="">Select Item</option>
            <?php foreach ($items as $item): ?>
                <option value="<?= htmlspecialchars($item['itemId']) ?>">
                    <?= htmlspecialchars($item['itemName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="uploaded_file"><strong>Choose Image File</strong></label>
        <input type="file" name="uploaded_file">
        <br>
        <input type="submit" name="submit" value="Upload Image">
        <p><?= $output ?></p>
    </form>
</body>