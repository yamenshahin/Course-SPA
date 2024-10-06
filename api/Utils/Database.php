<?php

namespace Utils;

use Config\DB;
use PDO;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $dbConfig = DB::get();
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}";
        $this->connection = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
