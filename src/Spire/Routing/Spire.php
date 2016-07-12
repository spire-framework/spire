<?php
namespace Spire\Routing;

use Spire\Auth\Auth;
use Spire\Config\Config;
use Spire\Database\Database;
use Spire\Facades\Session;

class Spire
{

    /**
     * Startup the system.
     *
     * @return void
     */
    public static function start()
    {
        // Load the application config.
        Config::file(path('config') . 'app.php');

        // Attempt a database connection.
        Database::initialize();

        // Initilize the session.
        Session::initialize();

        // Initialize auth.
        Auth::initialize();

        // Assign class aliases.
        $aliases = Config::item('aliases');

        // Check aliases is a valid array first.
        if (is_array($aliases))
        {
            foreach ($aliases as $alias => $class)
            {
                class_alias($class, $alias);
            }
        }
    }

    /**
     * Close the system.
     *
     * @return void
     */
    public static function close()
    {
        Session::finalize();
        Database::finalize();
    }

}
