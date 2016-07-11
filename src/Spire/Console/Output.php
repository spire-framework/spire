<?php
namespace Spire\Console;

class Output
{

    /**
     * Sends a message to the output.
     *
     * @param  string  $message  The message to show.
     * @return void
     */
    public static function send(string $message)
    {
        echo $message . "\n";
    }

}
