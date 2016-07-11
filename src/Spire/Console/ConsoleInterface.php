<?php
namespace Spire\Console;

interface ConsoleInterface
{

    /**
     * Help message for this command.
     *
     * @return string
     */
    public function help();

    /**
     * Execute the console command.
     *
     * @param  string  $task       Task name.
     * @param  array   $arguments  Command arguments.
     * @return string              Console output.
     */
    public function execute(string $task = '', array $arguments = []);

}
