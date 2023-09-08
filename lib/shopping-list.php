<?php

class shopping_list {

    private $connection;
    private $ingredient;
    private $article;

    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingredient = new ingredient($connection);
        $this->article = new article($connection);
    }

    private function selectIngredient($recipe_id) {
        return ($this->ingredient->selectIngredient($recipe_id));
    }

    private function selectArticle($article_id) {
        return($this->article->selectArticle($article_id));
    }



    // ADD RECIPE INGREDIENTS TO SHOPPING LIST
    public function addToShoppingList($recipe_id = NULL, $user_id = NULL) {
        // initialise ingredient

        if(is_null($recipe_id) || is_null($user_id)) {
            return NULL;
        }
        
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
        // if specific combination article_id and $user_id does not exist yet, create new shopping_list element for this combination
        if(empty($article)) {
            $sql_insert =   "INSERT INTO shopping_list (recipe_id, article_id, user_id, amount)
                            VALUES ($recipe_id, $value, $user_id, 1)";
                if(mysqli_query($this->connection, $sql_insert)) {
                    echo "Added article to shopping list";
                } else {
                    echo "Error: Unable to execute $sql_insert. " . mysqli_error($this->connection);
                }               
        } else { // if specific combination article_id and $user_id does exist, update number of articles +1 of current number value
            $sql_update = "UPDATE shopping_list SET amount = amount+1 WHERE article_id = $value AND user_id = $user_id";
            if(mysqli_query($this->connection, $sql_update)) {
                echo "This article is already on the shopping list and has to be updated";
            } else {
                echo "Error: Unable to execute $sql_update. " . mysqli_error($this->connection);            }
        } 
    }}



    // CHECK IF ARTICLE IS ON SHOPPING LIST - IF YES, SHOW SHOPPING LIST
    public function articleOnList($article_id, $user_id) {
        $sql = "SELECT * FROM shopping_list WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);

        $currentShoppingList = [];

        while($shoppingList = mysqli_fetch_array($result)) {

            $article = $this->selectArticle($shoppingList['article_id'], MYSQLI_ASSOC);

            $currentShoppingList[] = [
                "article_name" => $article['article_name'],
                "article_description" => $article['article_description'],
                "article_price" => $article['article_price'],
                "amount" => $shoppingList['amount'],
                "article_packaging" => $article['article_packaging'],
            ];
        }    

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
                return $currentShoppingList;
            }
        }} elseif (!$articleCheck) { // if article_id is not on shopping_list yet for user_id
            // return false
            echo "article is not yet on shopping list";
            //return FALSE;
            }
    }
        

}




?>