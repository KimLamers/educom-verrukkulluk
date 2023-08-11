<?php

class shopping_list {

    private $connection;
    private $ingredient;

    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingredient = new ingredient($connection);
    }

    private function selectIngredient($recipe_id) {
        return ($this->ingredient->selectIngredient($recipe_id));
    }


    public function addToShoppingList($recipe_id, $user_id) {
        // initialise ingredient
        $initIngredient = $this->selectIngredient($recipe_id); // for all ingredients of a recipe
        foreach($initIngredient as $key => $value) {
            $article_id = $value['article_id'];
            $articleIdArray[] = $article_id; 
        }

        // loop through article_ids for queries for all individual articles
        foreach($articleIdArray as $key => $value) {
            $sql = "SELECT * FROM shopping_list WHERE article_id = $value AND user_id = $user_id";
            $result = mysqli_query($this->connection, $sql);
            $article = mysqli_fetch_array($result, MYSQLI_ASSOC);
         

        // check if combination $article_id and $user_id exists in shopping_list database
        // if specific combination article_id and $$user_id does not exist yet, create new shopping_list element for this combination
        if(empty($article)) {
            $sql_insert =   "INSERT INTO shopping_list (id, article_id, user_id, number)
                            VALUES (NULL, $value, $user_id, 1)";
                if(mysqli_query($this->connection, $sql_insert)) {
                    echo "Added article to shopping list";
                } else {
                    echo "Error: Unable to execute $sql_insert. " . mysqli_error($this->connection);
                }               
        } else { // if specific combination article_id and $user_id does exist, update number of articles +1 of current number value
            $sql_update = "UPDATE shopping_list SET number = number+1 WHERE article_id = $value AND user_id = $user_id";
            if(mysqli_query($this->connection, $sql_update)) {
            echo "This article is already on the shopping list and has to be updated";
            } else {
                echo "Error: Unable to execute $sql_update. " . mysqli_error($this->connection);            }
        } 
    }}
    
    public function articleOnList($article_id, $user_id) {
        // clean data
        $article_id = mysqli_real_escape_string($this->connection, $article_id);
        $user_id = mysqli_real_escape_string($this->connection, $user_id);


        // retrieve all articles on shopping_list for specific user_id
        $sql = "SELECT * FROM shopping_list WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $shoppingList = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // sql query check shopping_list for specific article_id & user_id combination
        $sql_articleCheck = "SELECT * FROM shopping_list WHERE article_id = $article_id AND user_id = $user_id";
        $result_articleCheck = mysqli_query($this->connection, $sql_articleCheck);
        $articleCheck = mysqli_fetch_all($result_articleCheck, MYSQLI_ASSOC);


        // check if given article_id is already on shopping_list of given user_id
        if($articleCheck) {
        foreach($articleCheck as $key => $value) {
            // if article_id already on shopping_list for user_id
            if($value['article_id'] == $article_id && $value['user_id'] == $user_id) {
                // return shopping_list
                return $shoppingList;
            }
        }} elseif (!$articleCheck) { // if article_id is not on shopping_list yet for user_id
            // return false
            echo "article is not yet on shopping list";
                //return FALSE;
            }
        }
        

    }



?>