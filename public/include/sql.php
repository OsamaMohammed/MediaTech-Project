<?php

class OSASQL{

    private $db_connection;
    

    function __construct($autoConnect){
        // Initialize SQL connection
        if ($autoConnect)
            return $this->connect();
    }
    public function connect() {
        if ($this->db_connection == null) {
            $this->db_connection = new \PDO("sqlite:../database.sqlite");
        }
        return $this->db_connection;
    }
}