<?php

class user {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // public function select user

    public function selectUser($user_id) {

        $sql = "SELECT * FROM user WHERE id = $user_id";

        $results = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($results, MYSQLI_ASSOC);

        return($user);
    }
    
}
