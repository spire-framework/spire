<?php
namespace Spire\Database;

use \PDO;
use \PDOException;
use Spire\Config\Config;
use Spire\Exception\Exception;

class Database
{

    /**
     * @var /PDO The database connection.
     */
    protected static $connection;

    /**
     * Get the current connection.
     *
     * @return \PDO
     */
    public static function connection()
    {
        return static::$connection;
    }

    /**
     * Initializes the database connection.
     *
     * @return void
     */
    public static function initialize()
    {
        // Load the database config file.
        Config::file(path('config') . 'database.php', 'database');

        // Connect to the database.
        static::$connection = static::connect();
    }

    /**
     * Finalize the database connection.
     *
     * @return void
     */
    public static function finalize()
    {
        // Close connection.
        static::$connection = null;
    }

    /**
     * Connect to the database.
     *
     * @return \PDO
     */
    private static function connect()
    {
        // Setup connection settings.
        $driver     = Config::item('driver', 'database');
        $host       = Config::item('host', 'database');
        $username   = Config::item('username', 'database');
        $password   = Config::item('password', 'database');
        $name       = Config::item('name', 'database');
        $dsn        = sprintf('%s:host=%s;dbname=%s', $driver, $host, $name);
        $options    = [
            PDO::ATTR_PERSISTENT    => false,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        ];

        // Don't attempt a connection if we have no database username, name
        // or driver.
        if ($driver === '' || $username === '' || $name === '')
        {
            return null;
        }

        // Attempt to connect to the database.
        try
        {
            $connection = new PDO($dsn, $username, $password, $options);
        }
        catch (PDOException $error)
        {
            throw new Exception($error->getMessage());
        }

        // Return connection if successful.
        return $connection ?? null;
    }

}
