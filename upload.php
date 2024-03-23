<?php
if(!empty($_POST)) {
    $postTitle = $_POST['postTitle'];  #sprawdzić co to $_POST
    $postDescription = $_POST['postDescription'];
    $targetDirectory = "img/"; # to potencjalnie nie działa
    // $fileName = hash('sha256', $_FILES['file']['name'].microtime());
    $fileName = $_FILES['file']['name'];
   // $fileString = file_get_contents($_FILES['file']['tmp_name']);
   // $gdImage = imagecreatefromstring($fileString);
   move_uploaded_file($_FILES['file']['tmp_name'], $targetDirectory.$fileName);

    /*
    $finalURL = "http://localhost/post/img/".$fileName.".webp";
    $internalURL = "img/".$fileName.".webp";

    imagewebp($gdImage, $internalURL);
*/
    $authorID = 1;
    // $imageURL = "localhost/post/img/".$fileName;
    $imageURL = "img/".$fileName;


    $db = new mysqli('localhost', 'root', '', 'post');
    $q = $db->prepare("INSERT INTO post (author, imgURL, title) VALUES (?, ?, ?)");

    $q->bind_param("iss", $authorID, $imageURL, $postTitle);
    $q->execute();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj nowy post</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="postTitleInput">Tytuł posta:</label>
        <input type="text" name="postTitle" id="postTitleInput">
        <br>
        <label for="postDescriptionInput">Opis posta:</label>
        <input type="text" name="postDescription" id="postDescriptionInput">
        <br>
        <label for="fileInput">Obrazek:</label>
        <input type="file" name="file" id="fileInput">
        <br>
        <input type="submit" value="Wyślij!">
    </form>
</body>
</html>