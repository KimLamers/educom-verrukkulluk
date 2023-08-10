<?php

class shopping_list {

    private $connection;
    private $ingredient;
    private $article;
    private $user;

    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingredient = new ingredient($connection);
        $this->article = new article($connection);
        $this->user = new user($connection);
    }

    private function selectIngredient($recipe_id) {
        return ($this->ingredient->selectIngredient($recipe_id));
    }

    private function selectArticle($ingredient_id) {
        return ($this->article->selectArticle($ingredient_id));
    }

    private function selectUser($user_id) {
        return ($this->user->selectUser($user_id));
    }



    public function addToShoppingList($recipe_id, $user_id) {
        // initialise & article
        $initIngredient = $this->selectIngredient($recipe_id); // for all ingredients of a recipe
        foreach($initIngredient as $key => $value) {
            $article_id = $value['article_id'];
            $articleIdArray[] = $article_id; // all articles for a recipe
        }
    
        // check if combination $article_id and $user_id exists in shopping_list database
        // loop through article_ids for queries for all individual articles
        foreach($articleIdArray as $key => $value) {
        $sql = "SELECT * FROM shopping_list WHERE article_id = $article_id AND user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $resultArray[] = $result; // 4 queries, one for each article

        foreach($resultArray as $key => $value) {
        $article = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $articleArray[] = $article;
        if (!$result) {
            return NULL;
        } return $articleArray; // only last article retrieved so loop through array

        if(empty($article)) {
            $sql_insert =   "INSERT INTO shopping_list (id, article_id, user_id)
                            VALUES (NULL, $article_id, $user_id)";
                if(mysqli_query($this->connection, $sql_insert)) {
                    echo "Added article to shopping list"; // Only last article got added to shopping list, so loop through array somewhere
                } else {
                    echo "Error: Unable to execute $sql_insert. " . mysqli_error($this->connection); // no error
                }               
        } else {
            $sql_update = "UPDATE shopping_list SET column2=17 WHERE id = 1";
            echo "This article is already on the shopping list and has to be updated"; // First 3 
        }
    }

        }
        
    }



        // function addToShoppingList($recipe_id, $user_id) {
        // $ingredient = selectIngredient($recipe_id)
        // while $ingredient
        // article on list (ingredient->article_id, user_id)?
        // No: add article || Yes: update article
        // end





        // function articleOnList($article_id, $user_id)
        // $groceries = getShoppingList($user_id)
        // while($groceries)
        // $groceries->$article_id == article_id?
        // No:  || Yes: return $groceries
        // return FALSE

}









?>