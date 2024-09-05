<?php

class DatabaseConnection
{
    private $connection;

    public function __construct()
    {
        try {
            // Sqlite3 Configuration
            $this->connection = new PDO('sqlite:' . __DIR__ . '/../../database.db');

            // Uncomment this for MySQL configuration
            /*
            $host = $_ENV['DB_HOST'];
            $database = $_ENV['DB_DATABASE'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];
            $this->connection = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password, array(
                PDO::ATTR_PERSISTENT => true
            ));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            */
        } catch (PDOException $e) {
            echo '<strong>PDO Error: ' . $e->getMessage() . '</strong><br />';
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
