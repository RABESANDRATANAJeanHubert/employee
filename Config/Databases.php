<?php

/**
 * Class Database
 * A singleton class to manage the database connection.
 */
class Database
{
    /**
     * @var PDO|null Holds the single instance of the PDO connection.
     */
    private static $instance = null;

    /**
     * Get the single instance of the database connection.
     *
     * This method ensures only one connection is established (singleton pattern).
     * If the connection does not exist, it initializes a new PDO instance.
     *
     * @return PDO The database connection instance.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new PDO('mysql:host=localhost;dbname=testphp', 'root', '');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}

?>