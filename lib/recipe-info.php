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

        $sql = "SELECT * FROM recipe_info WHERE id = $recipe_info_id";
        $result = mysqli_query($this->connection, $sql);
        
        $recipe_info = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return($recipe_info);

        $recipeInfoArray = [];

        while($recipe_info = mysqli_fetch_array($result)){
            
            // if record type is O

                // get user

            // elseif record type is F

                // get user

            // else
            
                // no need for user


        }

    }
    

}


?>