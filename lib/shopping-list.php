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
        // initialise & article
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
        } else { // specific combination article_id and $user_id does exist, update number of articles +1 of current number value
            $sql_update = "UPDATE shopping_list SET number = number+1 WHERE article_id = $value AND user_id = $user_id";
            if(mysqli_query($this->connection, $sql_update)) {
            echo "This article is already on the shopping list and has to be updated";
            } else {
                echo "Error: Unable to execute $sql_update. " . mysqli_error($this->connection);            }
        } 
    }}
    


        // function articleOnList($article_id, $user_id)
        // $groceries = getShoppingList($user_id)
        // while($groceries)
        // $groceries->$article_id == article_id?
        // No:  || Yes: return $groceries
        // return FALSE

}









?>