<?php
namespace Spire\Console;

use Spire\Routing\Spire;

class Console
{

    /**
     * @var array Available commands.
     */
    protected static $commands = [
        'migrate'   => '\\Spire\\Database\\Migration\\Console'
    ];

    /**
     * Initializes the console.
     *
     * @return void
     */
    public static function initialize()
    {
        // Startup Spire.
        Spire::start();

        // Get the arguments.
        $arguments = $_SERVER['argv'] ?? [];

        // Clear the executed file from the arguments.
        array_shift($arguments);

        // Get the command and task.
        list($command, $task) = explode('::', $arguments[0]);

        // Get the final arguments by removing the command.
        array_shift($arguments);

        // Do we have a valid command?
        $class = static::$commands[$command] ?? false;

        // If so run it.
        if ($class)
        {
            $console = new $class;
            $message = $console->execute((string)$task, $arguments);

            if (is_string($message))
            {
                Output::send($message);
            }
        }

        // Close Spire.
        Spire::close();
    }

}
