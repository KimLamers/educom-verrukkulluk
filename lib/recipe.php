<?php

require_once("lib/user.php");
require_once("lib/kitchen-type.php");
require_once("lib/ingredient.php");
require_once("lib/recipe-info.php");
require_once("lib/article.php");



class recipe
{

    private $connection;
    private $user;
    private $kitchen;
    private $type;
    private $ingredient;
    private $article;
    private $ratingStepsRemarks;


    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->user = new user($connection);
        $this->kitchen = new kitchen_type($connection);
        $this->type = new kitchen_type($connection);
        $this->ingredient = new ingredient($connection);
        $this->article = new article($connection);
        $this->ratingStepsRemarks = new recipe_info($connection);
    }

    private function selectUser($user_id) {
        return ($this->user->selectUser($user_id));
    }

    private function selectKitchenType($kitchen_type_id) {
        return ($this->kitchen->selectKitchenType($kitchen_type_id));
    }

    private function selectIngredient($recipe_id) {
        return ($this->ingredient->selectIngredient($recipe_id));
    }

    private function selectArticle($ingredient_id) {
        return ($this->article->selectArticle($ingredient_id));
    }

    private function selectRecipeInfoById($recipe_id) {
        return ($this->ratingStepsRemarks->selectRecipeInfoById($recipe_id));
    }


    public function selectRecipeById($recipe_id = NULL) {

        $sql = "SELECT * FROM recipe";
        if(!is_null($recipe_id)) {
            $sql .= " WHERE id  = $recipe_id";
        }

        $result = mysqli_query($this->connection, $sql);
        
        while($recipe = mysqli_fetch_array($result)) { 
            // get user
            $user = $this->selectUser($recipe['user_id']);
            // get kitchen
            $kitchen = $this->selectKitchenType($recipe['kitchen_id']);
            // get type
            $type = $this->selectKitchenType($recipe['type_id']);
            // get ingredients
            $ingredients = $this->selectIngredient($recipe['id']);
            
            $recipeArray[] = [
                "recipe_id" => $recipe['id'],
                "kitchen_id" => $recipe['kitchen_id'],
                "type_id" => $recipe['type_id'],
                "user_id" => $recipe['user_id'],
                "date_added" => $recipe['date_added'],
                "recipe_title" => $recipe['recipe_title'],
                "recipe_description_short" => $recipe['recipe_description_short'],
                "recipe_description_long" =>  $recipe['recipe_description_long'],
                "recipe_image" =>  $recipe['recipe_image'],
                "number_of_people" => $recipe['number_of_people'],
                "username" => $user['username'],
                "password" => $user['password'],
                "email" => $user['email'],
                "user_image" => $user['user_image'],
                "record_type_kitchen" => $kitchen['record_type'],
                "description_kitchen" => $kitchen['description'],
                "record_type_type" => $type['record_type'],
                "description_type" => $type['description'],
                "ingredients" => $ingredients,
                "recipe_price" => array_sum(array_column($ingredients, 'article_price')),
                "recipe_calories" => array_sum(array_column($ingredients, 'article_calories')),
                "recipe_rating" => $this->ratingStepsRemarks->calcAverageRating($recipe['id']),
            ];
        }
        return ($recipeArray);
    }

    /// PUT THESE IN SELECT RECIPE FUNCTION
    public function calcPriceForRecipe($recipe_id) {
        // get recipeArray from selectRecipeById
        $recipeArray = $this->selectRecipeById($recipe_id);
        $recipePrice = array_sum(array_column($recipeArray, 'article_price'));
        return ($recipePrice);
    }

    public function calcCaloriesForRecipe($recipe_id) {
        // get recipeArray from selectRecipeById
        $recipeArray = $this->selectRecipeById($recipe_id);
        $recipeCalories = array_sum(array_column($recipeArray, 'article_calories'));
        return ($recipeCalories);
    }


    public function selectSteps($recipe_id)
    {
        // initialise recipe_info
        $initSteps = $this->selectRecipeInfoById($recipe_id);

        // loop through array to find record_type = B with corresponding number_field (step number) and text_field (step descriptions)
        foreach ($initSteps as $key => $value) {
            if ($value['record_type'] === 'B') {
                $steps[] = [
                    $value['number_field'],
                    $value['text_field'],
                ];
            }
        }
        return ($steps);
    }

    public function selectRemarks($recipe_id)
    {
        // initialise recipe_info
        $initRemarks = $this->selectRecipeInfoById($recipe_id);

        // loop through array to find record_type = O with corresponding text_field, user_id, username, date and user_image
        foreach ($initRemarks as $key => $value) {
            if ($value['record_type'] === 'O') {
                $remarks[] = [
                    $value['text_field'],
                    $value['user_id'],
                    $value['username'],
                    $value['date'],
                    $value['user_image'],
                ];
            }
        }
        return ($remarks);
    }

    public function determineFavorite($recipe_id, $user_id)
    {
        // check if for recipe_id a user_id already has a record_type = F

        // initialise recipe_info
        $initFavorite = $this->selectRecipeInfoById($recipe_id, $user_id);

        // loop through array to find record_type = 'F' for specified recipe_id and user_id
        foreach ($initFavorite as $key => $value) {
            if ($value['recipe_id'] == $recipe_id && isset($value['user_id']) && $value['user_id'] == $user_id && $value['record_type'] === 'F') {
                $favoriteArray[] = [
                    $value,
                ];
            }
        }
        // determine if specific recipe has already been added to favorites by specific user
        // false = not added, true = added
        if (empty($favoriteArray)) {
            echo "The recipe can still be added to your favorites";
            return FALSE;
        } else {
            echo "This recipe has already been added to your favorites";
            return TRUE;
        }
    }

    public function selectRating($recipe_id)
    {
        // initialise recipe_info
        $initRating = $this->selectRecipeInfoById($recipe_id);

        // loop through array to find record_type = W with correstponding number_field (rating)
        foreach ($initRating as $key => $value) {
            if ($value['record_type'] === 'W') {
                $rating[] = $value['number_field'];
            }
        }

        // calculate average rating
        $ratingSum = array_sum($rating);
        $ratingAverage = $ratingSum / count($rating);
        return ($ratingAverage);
    }
 
}
