<?php

class ingredient {
    
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // public function select ingredients

    public function selectIngredient($ingredients_id) {

        $sql = "SELECT * FROM ingredients WHERE id = $ingredients_id";

        $result = mysqli_query($this->connection, $sql);
        $ingredients = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return ($ingredients);
    }

    // Ingredient list per recipe

    public function selectIngredientsForRecipe($recipe_id) {
        

        $sql = "SELECT * FROM ingredients WHERE recipe_id = $recipe_id";
        
        $result = mysqli_query($this->connection, $sql);
        $articleListForRecipe = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($articleListForRecipe);
    }

    // make while loop through articles to get specific article info (private function)
    
        public function getArticleInfo($articleListForRecipe) {
            $getArticle_info = (array_filter($articleListForRecipe, function($key) {
                return $key == 'article_id';
            }, ARRAY_FILTER_USE_KEY));
        }
    
    
        // // private function select article info for each separate ingredient

    // private function selectArticles($articles_id) {
    //     $this->articles = $articles;
    
    //     $sql = "SELECT * FROM ingredients WHERE id = $articles_id";
    
    //     $result = mysqli_query($this->connection, $sql);
    //     $articlesForIngredients = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    //     return($articlesForIngredients);
    // }
}
