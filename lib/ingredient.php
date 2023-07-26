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

    private



}

echo "These are the ingredients!";