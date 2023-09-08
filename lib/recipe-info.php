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


    public function selectRecipeInfoById($recipe_id) {
        //clean data
        $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);

        $sql = "SELECT * FROM recipe_info WHERE recipe_id = $recipe_id";
        $result = mysqli_query($this->connection, $sql);
        
        $recipeInfoArray = [];

        
        while($recipe_info = mysqli_fetch_array($result)) {
    
            $recipeInfoArray[] = [
                "id" => $recipe_info['id'],
                "record_type" => $recipe_info['record_type'],
                "recipe_id" => $recipe_info['recipe_id'],
                "date" => $recipe_info['date'],
                "number_field" => $recipe_info['number_field'],
                "text_field" => $recipe_info['text_field'],
            ];

            
        // if record type is 'O' or 'F'
            if(isset($recipe_info['record_type']) && $recipe_info['record_type'] === 'O' || $recipe_info['record_type'] === 'F') { 

                // get user
                $user = $this->selectUser($recipe_info['user_id'], MYSQLI_ASSOC);

                $recipeInfoArray[] = [

                    "username" => $user['username'],
                    "password" => $user['password'],
                    "email" => $user['email'],
                    "user_image"=> $user['user_image'],
                ];

            }
        }
        return($recipeInfoArray);
    }


    /** COMMENTS **/
    public function selectComments($recipe_id) {

        $sql = "SELECT * FROM recipe_info WHERE recipe_id = $recipe_id AND record_type = 'O'";
        $result = mysqli_query($this->connection, $sql);
        
        $recipeInfoCommentArray = [];

        while($recipe_info = mysqli_fetch_array($result)) {
            $user = $this->selectUser($recipe_info['user_id']);

            $recipeInfoCommentArray[] = [
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
        }
        return($recipeInfoCommentArray);
    }


    /** PREPARATION  **/
    public function selectPreparation($recipe_id) {

        $sql = "SELECT * FROM recipe_info WHERE recipe_id = $recipe_id AND record_type = 'B'";
        $result = mysqli_query($this->connection, $sql);
        
        $recipeInfoPreparationArray = [];

        while($recipe_info = mysqli_fetch_array($result)) {

            $recipeInfoPreparationArray[] = [
                "id" => $recipe_info['id'],
                "record_type" => $recipe_info['record_type'],
                "recipe_id" => $recipe_info['recipe_id'],
                "date" => $recipe_info['date'],
                "number_field" => $recipe_info['number_field'],
                "text_field" => $recipe_info['text_field'],
            ];
        }
        return($recipeInfoPreparationArray);
    }

    /** RATING AVERAGE **/
    public function calcAverageRating($recipe_id) {
        
        /* get all ratings for specified recipe_id */
            $sql = "SELECT * FROM recipe_info WHERE recipe_id = $recipe_id AND record_type = 'W'";

            $result = mysqli_query($this->connection, $sql);

            $totalValueOfRatings = 0;
            $numberOfRatings = 0;

            while($recipe_info = mysqli_fetch_array($result)) {
                $totalValueOfRatings = $totalValueOfRatings + $recipe_info['number_field'];
                $numberOfRatings++;
            }

            $averageRating = $totalValueOfRatings > 0 ? $totalValueOfRatings / $numberOfRatings: NULL;

            return(round($averageRating));
    }

    /* CREATE RECORD FOR RATING IN DATABASE */
    public function createRatingRecord($recipe_id = NULL, $number_field = NULL) {
        $recipe_id = mb_substr($recipe_id, 0, 1);
        $sql= "INSERT INTO recipe_info (record_type, recipe_id, number_field)
        VALUES ('W', $recipe_id, $number_field)";

        $result = mysqli_query($this->connection, $sql);
        return( [
            "recipe_id" => $recipe_id,
            "value" => $number_field,
            "average" => round($this->calcAverageRating($recipe_id))
        ]);
    }


    /** FAVORITES **/
    public function addRecipeToFavorites($recipe_info_id, $recipe_id, $user_id) {
        // check if record already exists
        // clean data
        $recipe_info_id = mysqli_real_escape_string($this->connection, $recipe_info_id);
        $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);
        $user_id = mysqli_real_escape_string($this->connection, $user_id);

        // sql query
        $sql = "INSERT INTO recipe_info (id, record_type, recipe_id, user_id, date, number_field, text_field)
                VALUES (NULL, 'F', $recipe_id, $user_id, NULL, NULL, NULL)";

        // return success
        if (mysqli_query($this->connection, $sql)) {
            echo "Successfully added recipe to favorites!";
        } else {
            echo "Error: Unable to execute $sql. " . mysqli_error($this->connection);
        }

    }


    public function deleteRecipeFromFavorites($recipe_id, $user_id) {
        // check if record already exists
        // clean data
        $recipe_id = mysqli_real_escape_string($this->connection, $recipe_id);
        $user_id = mysqli_real_escape_string($this->connection, $user_id);

        // sql query
        $sql = "DELETE FROM recipe_info WHERE recipe_id = $recipe_id AND user_id = $user_id AND record_type = 'F' ";

        // return success
        if (mysqli_query($this->connection, $sql)) {
            echo "Successfully deleted recipe from favorites!";
        } else {
            echo "Error: Unable to execute $sql. " . mysqli_error($this->connection);
        }

    }
}

?>