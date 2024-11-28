<?php
/*******w******** 
    
    Name: Morgan VanCaeyzeele
    Date: November 24th, 2024
    Description: Final Project post page

****************/



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
</head>
<body>
<h1>Morgan Blog</h1>
<a href="index.php">Home</a>
    <form method="post" action="post.php">
        <label for="title">Title</label>
        <input id="title" name="title">
        <label for="content">Content</label>
        <textarea id="content" name="content" rows="15" cols="50"></textarea>
        <input type="submit">
    </form>
</body>
</html>