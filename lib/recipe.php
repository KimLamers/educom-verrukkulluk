<?php

class recipe {

    private $connection;
    private $user;
    private $kitchen;
    private $type;
    // private $ingredient;
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
    }

    private function selectUser($user_id) {
        return($this->user->selectUser($user_id));
    }

    private function selectKitchenType($kitchen_type_id) {
        return($this->kitchen->selectKitchenType($kitchen_type_id));
    }



    public function selectRecipeById($recipe_id) {
        // clean data
        $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);

        // sql query
        $sql = "SELECT * FROM recipe WHERE id = $recipe_id";
        $result = mysqli_query($this->connection, $sql);

        // $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $recipeArray = [];

        while($recipe = mysqli_fetch_array($result)) {
            // get user
            $user = $this->selectUser($recipe['user_id'], MYSQLI_ASSOC);
            // get kitchen
            $kitchen = $this->selectKitchenType($recipe['kitchen_id'], MYSQLI_ASSOC);
            // get type
            $type = $this->selectKitchenType($recipe['type_id'], MYSQLI_ASSOC);


            $recipeArray[] = [
                "id" => $recipe['id'],
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

        }
        return($recipeArray);


    }





}

?>