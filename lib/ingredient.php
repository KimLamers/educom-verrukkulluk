<?php

class ingredient {
    
    
    private $connection;
    private $article;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->article = new article($connection);
    }

    private function selectArticle($article_id) {
        return($this->article->selectArticle($article_id));
    }

    

    // public function select ingredients + private select articles

    public function selectIngredient($recipe_id) {
        //clean data
        $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);

        $sql = "SELECT * FROM ingredients WHERE recipe_id = $recipe_id";
        $result = mysqli_query($this->connection, $sql);

        $articlesAndIngredients = [];
        
        while($ingredients = mysqli_fetch_array($result)) {

            $article = $this->selectArticle($ingredients['article_id'], MYSQLI_ASSOC);

            $articlesAndIngredients[] = [
                "id" => $ingredients['id'],
                "recipe_id" => $ingredients['recipe_id'],
                "article_id" => $ingredients['article_id'],
                "number" => $ingredients['number'],
                "article_name" => $article['article_name'],
                "article_description" => $article['article_description'],
                "article_price" => $article['article_price'],
                "article_unit" => $article['article_unit'],
                "article_packaging" => $article['article_packaging'],
                "article_calories" => $article['article_calories'],
            ];
        }

        return($articlesAndIngredients);

    }

}

?>
