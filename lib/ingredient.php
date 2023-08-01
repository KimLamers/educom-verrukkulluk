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


    // Ingredient list per recipe

    public function selectIngredientsForRecipe($recipe_id) {
        

        $sql = "select * from ingredients where recipe_id = $recipe_id";
        
        $result = mysqli_query($this->connection, $sql);
        $articleListForRecipe = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($articleListForRecipe);
    }


    // make while loop through $articleListForRecipe array to get filter for article_id and get corresponding value
    
        public function getArticleInfo($articleListForRecipe) {
            $getArticle_info = (array_filter($articleListForRecipe, function($key) {
                return $key == 'article_id';
            }, ARRAY_FILTER_USE_KEY));

        }
    
    
        // input value acquired above into selectArticles private function to get corresponding article info

    private function selectArticles($articles_id) {
        $this->articles = $articles;
    
        $sql = "select * from ingredients where id = $articles_id";
    
        $result = mysqli_query($this->connection, $sql);
        $articlesForIngredients = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
        return($articlesForIngredients);

    }
}
