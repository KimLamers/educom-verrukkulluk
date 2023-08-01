<?php

class article {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selectArticle($articles_id) {
        // clean data
        $articles_id = mysqli_real_escape_string($this->connection, $articles_id);

        // sql query
        $sql = "SELECT * FROM articles WHERE id = $articles_id";
        
        $result = mysqli_query($this->connection, $sql);
        $article = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($article);

    }
    
}


