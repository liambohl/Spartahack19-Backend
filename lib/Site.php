<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 4/8/2018
 * Time: 10:41 PM
 */

namespace SpartahackV;

class Site{
    public function __construct()
    {
        // This ensures we only create the PDO object once
        if(self::$pdo == null) {
            try {
                self::$pdo = new \PDO(self::$dbHost,
                    self::$dbUser,
                    self::$dbPassword);
            } catch(\PDOException $e) {
                // If we can't connect we die!
                die("Unable to select database");
            }
        }
    }

    public function getEmail()
    {
        return self::$email;
    }

    public function getRoot()
    {
        return self::$root;
    }

    public function getTablePrefix()
    {
        return self::$tablePrefix;
    }

    public function getPdo()
    {
        return self::$pdo;
    }

    private static $email = 'bohllia1@msu.edu';                                     ///< Site owner email address
    private static $dbHost = 'mysql:host=mysql-user.cse.msu.edu;dbname=bohllia1';   ///< Database host name
    private static $dbUser = 'bohllia1';                                            ///< Database user name
    private static $dbPassword = 'thriftystairways';                                ///< Database password
    private static $tablePrefix = 'spartahackV_';                                   ///< Database table prefix
    private static $root = '/~bohllia1/spartahackV/';                               ///< Site root
    private static $pdo = null;                                                     ///< The PDO object (for database access)
}