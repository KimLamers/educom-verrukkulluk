<?php

class article {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selectArticle($articles_id) {

        $sql = "SELECT * FROM articles WHERE id = $articles_id";
        
        $result = mysqli_query($this->connection, $sql);
        $article = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($article);

    }
    
}


