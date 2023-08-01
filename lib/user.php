<?php

class user {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // public function select user

    public function selectUser($user_id) {

        // clean data
        $user_id = mysqli_real_escape_string($this->connection, $user_id);

        // sql query
        $sql = "SELECT * FROM user WHERE id = $user_id";

        $results = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($results, MYSQLI_ASSOC);

        return($user);
    }
    
}
