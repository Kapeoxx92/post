<?php
class Post {
    private $id;
    private $author;
    private $title;
    private $timestamp;
    private $imgUrl;

    public function __construct(int $id, string $author, string $title, string $timestamp, string $imgUrl) {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->timestamp = $timestamp;
        $this->imgUrl = $imgUrl;
    }

    public function GetTitle() : string {
        return $this->title;
    }
    public function GetAuthor() : string {
        return $this->author;
    }
    public function GetAuthorEmail() : string {
        return $this->author;
    }
    public function GetImageURL() : string {
        return $this->imgUrl;
    }
    public function GetTimestamp() : string {
        return $this->timestamp;
    }

    static function GetPosts() : array {
        // Connect to the database
        $db = new mysqli('localhost', 'root', '', 'cms');
    
        // Prepare the SQL query
        $sql = "SELECT post.ID, post.title, post.timestamp, post.imgUrl, user.email AS author 
                FROM `post` 
                INNER JOIN user ON user.id = post.authorID 
                ORDER BY timestamp DESC 
                LIMIT 10";
        $query = $db->prepare($sql);
    
        // Execute the query
        $query->execute();
    
        // Fetch the results
        $result = $query->get_result();
    
        // Create an array to store the Post objects
        $posts = [];
    
        // Loop through the results and create a Post object for each row
        while ($row = $result->fetch_assoc()) {
            $post = new Post($row['ID'], $row['author'], $row['title'], $row['timestamp'], $row['imgUrl']);
            $posts[] = $post;
        }
    
        // Close the database connection
        $db->close();
    
        // Return the array of Post objects
        return $posts;
    }
    static function CreatePost(string $title, string $description) : bool {
        
        $targetDirectory = "img/";
        $fileName = hash('sha256', $_FILES['file']['name'].microtime());

        $fileString = file_get_contents($_FILES['file']['tmp_name']);

        $gdImage = imagecreatefromstring($fileString);

        $finalUrl = "http://localhost/post/img/".$fileName.".webp";
        $internalUrl = "img/".$fileName.".webp";
        imagewebp($gdImage, $internalUrl);

        $authorID = $_SESSION['user']->getID();


        $db = new mysqli('localhost', 'root', '', 'post');
        $q = $db->prepare("INSERT INTO post (authorID, imgURL, title) VALUES (?, ?, ?)");
        $q->bind_param("iss", $authorID, $finalUrl, $title);
        if($q->execute())
            return true;
        else
            return false;
    }
}
?>