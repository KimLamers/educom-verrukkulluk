<?php

class kitchen_type {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // public function select kitchen & type

    public function selectKitchenType($kitchen_type_id) {

        $sql = "select * from kitchen_type where id = $kitchen_type_id";

        $result = mysqli_query($this->connection, $sql);
        $kitchen_type = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($kitchen_type);
    }
}
