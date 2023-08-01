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

    

    // public function select ingredients

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
                "article_name" => $articles['article_name'],
                "article_description" => $articles['article_description'],
                
            ];
        }

        return($articlesAndIngredients);

    }

    // // Ingredient list per recipe

    // public function selectIngredientsForRecipe($recipe_id) {
    //     // clean data
    //     $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);

    //     $sql = "SELECT * FROM ingredients WHERE recipe_id = $recipe_id";
    //     $result = mysqli_query($this->connection, $sql);

    //     $articleListForRecipe = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //     return($articleListForRecipe);
    // }

    // // init private selectArticle function

    // private function selectArticle($articles_id) {
    //     $this->articles = $articles;

    //     // clean data
    //     $articles_id = mysqli_real_escape_string($this->connection, $articles_id);

    //     // sql query
    //     $sql = "SELECT * FROM articles WHERE id = $articles_id";
        
    //     $result = mysqli_query($this->connection, $sql);
    //     $article = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //     return($article);
    // }


    // // make foreach loop through articles to get specific article_ids
    
    // public function getArticleInfoFromRecipe($articleListForRecipe) {
    //     $relatedArticles = [];

    //     foreach($articleListForRecipe as $value) {
    //         $article_id = $value['article_id'];
    //             if($article_id) {
    //                 $relatedArticles[] = selectArticle($articles_id);
    //             }
    //     }
    //     return($relatedArticles);
    // }    
}
