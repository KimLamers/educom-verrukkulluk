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

    /** RATING **/
    public function calcAverageRating($recipe_id) {
        
        /* get all ratings for specified recipe_id */
        $sql = "SELECT * FROM recipe_info WHERE recipe_id = $recipe_id AND record_type = 'W'";
        $result = mysqli_query($this->connection, $sql);

        while($recipe_info = mysqli_fetch_array($result)) {
            $recipeInfoRatingArray[] = [
                "id" => $recipe_info['id'],
                "record_type" => $recipe_info['record_type'],
                "recipe_id" => $recipe_info['recipe_id'],
                "number_field" => $recipe_info['number_field'],
            ];
        }

        /* put all retrieved ratings into seperate array */
        foreach ($recipeInfoRatingArray as $key => $value) {
            $rating[] = $value['number_field'];
        }

        /* and calculate the average rating */
        $ratingSum = array_sum($rating);
        $ratingAverage = $ratingSum / count($rating);

        return ($ratingAverage);
    }

    /* UPDATE RATING FROM FRONTEND TO DATABASE */
    // if clicked on a star on frontend (JQuery)
    public function addOrUpdateRatingRecord ($recipe_id, $user_id) {


        // query
        $sql = "SELECT * FROM recipe_info WHERE recipe_id = $recipe_id AND user_id = $user_id AND record_type = 'W'";
        $result = mysqli_query($this->connection, $sql);

        // check if record already exists
        if (mysqli_num_rows($result) > 0) { 

            // update record
            $sql_update = "UPDATE recipe_info
                           SET number_field = 3
                           WHERE recipe_id = $recipe_id AND user_id = $user_id AND record_type = 'W'";
                // check success
                if (mysqli_query($this->connection, $sql_update)) {
                    echo "Successfully updated the record ";
                } else {
                    echo "ERROR: unable to update record $sql_update. " . mysqli_error($this->connection);
                }

        // if record does not exist        
        } elseif (mysqli_num_rows($result) == 0) { 

            // create new record
            $sql_create = "INSERT INTO recipe_info (id, record_type, recipe_id, user_id, date, number_field, text_field)
                           VALUES (NULL, 'W', $recipe_id, $user_id, NULL, 3, NULL)";
                // check success 
                if (mysqli_query($this->connection, $sql_create)) {
                    echo "Record successfully created";
                } else {
                    echo "ERROR: unable to create record $sql_create. " . mysqli_error($this->connection);
                }
        }
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