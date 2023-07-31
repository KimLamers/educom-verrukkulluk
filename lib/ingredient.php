<?php


class ingredient {
    
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // public function select ingredients

    public function selectIngredient($ingredients_id) {

        $sql = "select * from ingredients where id = $ingredients_id";

        $result = mysqli_query($this->connection, $sql);
        $ingredients = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return ($ingredients);
    }


    // private function select articles

    private function selectArticles($articles_id) {
        $this->articles = $articles;

        $sql_1 = "select * from ingredients where id = $articles_id";

        $result = mysqli_query($this->connection, $sql);
        $articlesForIngredients = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($articlesForIngredients);
    }

    /// Make private function accessible in index for each recipe

    // BURGER

    public function selectIngredientsBurger($articlesForIngredients) {
        

        $sql = "select * from ingredients where recipe_id = 1";
        
        $result = mysqli_query($this->connection, $sql);
        $articleListBurger = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
        return($articleListBurger);
    }

    // SUSHI

    public function selectIngredientsSushi($articlesForIngredients) {

        $sql = "select * from ingredients where recipe_id = 2";

        $result = mysqli_query($this->connection, $sql);
        $articleListSushi = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($articleListSushi);
    }

    // RISOTTO

    public function selectIngredientsRisotto($articlesForIngredients) {

        $sql = "select * from ingredients where recipe_id = 3";

        $result = mysqli_query($this->connection, $sql);
        $articleListRisotto = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($articleListRisotto);
    }

    // PIZZA

    public function selectIngredientsPizza($articlesForIngredients) {

        $sql = "select * from ingredients where recipe_id = 4";

        $result = mysqli_query($this->connection, $sql);
        $articleListPizza = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($articleListPizza);
    }

    /// put individual recipe ingredients in array for index


    // public function selectIngredientsForRecipe($arrayIngredients) {

    //         foreach($arrayIngredients as $value) {
    //         return($value);
    //         }
    //     }
}