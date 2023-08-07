<?php

class recipe {

    private $connection;
    private $user;
    private $kitchen;
    private $type;
    private $ingredient;
    private $article;
    // calculate calories
    // calculate price
    // select rating
    // select steps
    // select remarks
    // determine favorite

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
        $this->kitchen = new kitchen_type($connection);
        $this->type = new kitchen_type($connection);
        $this->ingredient = new ingredient($connection);
        $this->article = new article($connection);
    }

    private function selectUser($user_id) {
        return($this->user->selectUser($user_id));
    }

    private function selectKitchenType($kitchen_type_id) {
        return($this->kitchen->selectKitchenType($kitchen_type_id));
    }

    private function selectIngredient($recipe_id) {
        return($this->ingredient->selectIngredient($recipe_id));
    }

    private function selectArticle($ingredient_id) {
        return($this->article->selectArticle($ingredient_id));
    }



    public function selectRecipeById($recipe_id) {
        // clean data
        $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);

        // sql query
        $sql = "SELECT * FROM recipe WHERE id = $recipe_id";
        $result = mysqli_query($this->connection, $sql);

        // sql query ingredients
        $sql_ingredients = "SELECT * FROM ingredients WHERE recipe_id = $recipe_id";
        $resuls_ingredients = mysqli_query($this->connection, $sql_ingredients);

        $recipeArray = [];

        while($recipe = mysqli_fetch_array($result)) {
            // get user
            $user = $this->selectUser($recipe['user_id'], MYSQLI_ASSOC);
            // get kitchen
            $kitchen = $this->selectKitchenType($recipe['kitchen_id'], MYSQLI_ASSOC);
            // get type
            $type = $this->selectKitchenType($recipe['type_id'], MYSQLI_ASSOC);
            $recipeArray[] = [
                "recipe_id" => $recipe['id'],
                "kitchen_id" => $recipe['kitchen_id'],
                "type_id" => $recipe['type_id'],
                "user_id" => $recipe['user_id'],
                "date_added" => $recipe['date_added'],
                "recipe_title" => $recipe['recipe_title'],
                "recipe_description_short" => $recipe['recipe_description_short'],
                "recipe_description_long" => $recipe['recipe_description_long'],
                "recipe_image" => $recipe['recipe_image'],
                "username" => $user['username'],
                "password" => $user['password'],
                "email" => $user['email'],
                "user_image" => $user['user_image'],
                "record_type_kitchen" => $kitchen['record_type'],
                "description_kitchen" => $kitchen['description'],
                "record_type_type" => $type['record_type'],
                "description_type" => $type['description'],
            ];
            // get ingredient and articles
            $ingredient = $this->selectIngredient($recipe['id'], MYSQLI_ASSOC);
                while($ingredient = mysqli_fetch_array($resuls_ingredients)) {                    
                    $recipeArray[] = [
                        "ingredient_id" => $ingredient['id'],
                        "article_id" => $ingredient['article_id'],
                        "number" => $ingredient['number'],
                    ];
                    // get article
                    $article = $this->selectArticle($ingredient['article_id'], MYSQLI_ASSOC);
                        $recipeArray[] = [
                            "article_id" => $article['id'],
                            "article_name" => $article['article_name'],
                            "article_description" => $article['article_description'],
                            "article_price" => $article['article_price'],
                            "article_unit" => $article['article_unit'],
                            "article_packaging" => $article['article_packaging'],
                            "article_calories" => $article['article_calories'],
                        ];
                }
        }
        return($recipeArray);


    }





}

?>