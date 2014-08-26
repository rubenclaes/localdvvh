<?php

/**
 * Description of database
 *
 * @author Ruben
 */
class Database {

    private static $dbh;

    private function __construct() {}

    public static function getConnection() {
        try {
            if (!isset(self::$dbh)) {
                self::$dbh = new PDO("mysql:host=localhost;dbname=deverenigdevrie", "root", "");
//                 self::$dbh = new PDO("mysql:host=deverenigdevriendenheusden.be.mysql;dbname=deverenigdevrie", "deverenigdevrie", "nBFEW49C");
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); 
            }
            return self::$dbh;
        } catch (PDOException $e) {
            $e->getMessage();
            echo "A database error was encountered -> " . $e->getMessage();
        }
    }

    private function __clone() {}

}
