<?php

class OSASQL{

    private static $db_connection;
    

    public static function connect() {
        if (self::$db_connection == null) {
            try {
                self::$db_connection = new \PDO("sqlite:../database.sqlite");
            } catch (Exception $e) {
                echo($e->getMessage());
                exit('Something weird happened'); //something a user can understand
            }
        }
        self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$db_connection;
    }
}