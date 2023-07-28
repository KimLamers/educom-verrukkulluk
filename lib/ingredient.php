<?php

class ingredient {
    
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    // public function select ingredients

    public function selectIngredient($ingredients_id) {

        $sql = "select * from ingredients where id = $ingredients_id";

        $result = mysqli_query($this->connection, $sql);
        $ingredients = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return ($ingredients);
    }


    // private function select articles

    private function selectArticles($articles_id) {
        $this->articles = $articles;

        $sql_1 = "select * from ingredients where id = $articles_id";

        $result = mysqli_query($this->connection, $sql);
        $articlesForIngredients = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return ($articlesForIngredients);
    }

    // Make private function accessible in index

    public function selectIngredientsBurger($articlesForIngredients) {
        

        $sql = "select * from ingredients where recipe_id = 2";
        
        $result = mysqli_query($this->connection, $sql);
        $articleList = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return ($articleList);

    }
}

