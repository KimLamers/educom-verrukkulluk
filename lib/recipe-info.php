<?php

class recipe_info {


    private $connection;
    private $user;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
    }

    private function selectUser($user_id) {
        return($this->user->selectUser($user_id));
    }


    public function selectRecipeInfoById($recipe_info_id) {
        //clean data
        $recipe_info_id = mysqli_real_escape_string($this->connection, $recipe_info_id);

        $sql = "SELECT * FROM recipe_info WHERE recipe_id = 1";
        $result = mysqli_query($this->connection, $sql);
        
        // $recipe_info = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $recipeInfoArray = [];
    

        
        while($recipe_info = mysqli_fetch_array($result)) {
            
        // if record type is 'O'
            if(isset($recipe_info['record_type']) && $recipe_info['record_type'] === 'O') { 

                // get user
                $user = $this->selectUser($recipe_info['user_id'], MYSQLI_ASSOC);

                $recipeInfoArray[] = [
                    "id" => $recipe_info['id'],
                    "record_type" => $recipe_info['record_type'],
                    "recipe_id" => $recipe_info['recipe_id'],
                    "user_id" => $recipe_info['user_id'],
                    "date" => $recipe_info['date'],
                    "number_field" => $recipe_info['number_field'],
                    "text_field" => $recipe_info['text_field'],
                    "username" => $user['username'],
                    "password" => $user['password'],
                    "email" => $user['email'],
                    "user_image"=> $user['user_image'],
                ];
                // if record type is 'F'
            } elseif(isset($recipe_info['record_type']) && $recipe_info['record_type'] === 'F') {                // else for testing
                
                // get user
                $user = $this->selectUser($recipe_info['user_id'], MYSQLI_ASSOC);

                $recipeInfoArray[] = [
                    "id" => $recipe_info['id'],
                    "record_type" => $recipe_info['record_type'],
                    "recipe_id" => $recipe_info['recipe_id'],
                    "user_id" => $recipe_info['user_id'],
                    "date" => $recipe_info['date'],
                    "number_field" => $recipe_info['number_field'],
                    "text_field" => $recipe_info['text_field'],
                    "username" => $user['username'],
                    "password" => $user['password'],
                    "email" => $user['email'],
                    "user_image" => $user['user_image'],
                ];
                // if record type not 'O' or 'F'
            } else {
                 
                // no need to get user
                $recipeInfoArray[] = [
                    "id" => $recipe_info['id'],
                    "record_type" => $recipe_info['record_type'],
                    "recipe_id" => $recipe_info['recipe_id'],
                    "date" => $recipe_info['date'],
                    "number_field" => $recipe_info['number_field'],
                    "text_field" => $recipe_info['text_field'],
                ];
            }
        }
        return($recipeInfoArray);
    }

    // public function add record_type F to recipe_info for user. Need user_id, recipe_id and record_type.
    
    // to add to database: INSERT  (INSERT INTO table_name (column1, column2, column3) VALUES (value1, value2, value)
    // to delete from database: DELETE (DELETE FROM tabele_name WHERE some_column = some_value)

        // if user did not already add to favorites

        // add to favorites

        // if already added, continue

    // public function delete record_type F from recipe_info for user

        // if favorites

        // delete from favorites

        // if not in favorites, continue

    
}
    



?>