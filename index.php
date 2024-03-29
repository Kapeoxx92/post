<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>Nagłowek strony</h1>
    </header>
    <div id="container">
        <?php
        $db = new mysqli('localhost', 'root', '', 'post');
        $q = $db->prepare("SELECT post.id, post.imgURL, post.title, 
                                    post.timestamp, user.login 
                            FROM `post` 
                            INNER JOIN user ON post.author = user.ID
                            ORDER BY post.timestamp DESC;");
        $q->execute();
        $result = $q->get_result();
        while($row = $result->fetch_assoc()) {
            echo '<div class="post-block">';
            echo '<h2 class="post-title">'.$row['title'].'</h3>';
            echo '<h3 class="post-author">'.$row['login'].'</h6>';
            echo '<img src="'.$row['imgURL'].'" alt="obrazek posta" class="post-image">';
            echo '<p class="post-description">TODO: Opis posta</p>';
            echo '<div class="post-footer">
                <span class="post-meta">'.$row['timestamp'].'</span>
                <span class="post-score">TODO: punkty</span>
                </div>';
            echo '</div>';
        }
        ?>

       
    </div>
</body>
</html>