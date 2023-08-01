<?php

class kitchen_type {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // public function select kitchen & type

    public function selectKitchenType($kitchen_type_id) {

        // clean data
        $kitchen_type_id = mysqli_real_escape_string($this->connection, $kitchen_type_id);

        // sql query
        $sql = "SELECT * FROM kitchen_type WHERE id = $kitchen_type_id";

        $result = mysqli_query($this->connection, $sql);
        $kitchen_type = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($kitchen_type);
    }
    
}
