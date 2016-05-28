<?php
namespace Spire\Config;

use Spire\Exception\Exception;

class Config
{

    /**
     * Retrieves a config item.
     *
     * @param  string  $key
     * @param  string  $group
     * @return mixed
     */
    public static function item(string $key, string $group = 'items')
    {
        return Repository::retrieve($group, $key);
    }

    /**
     * Loads a config file.
     *
     * @param  string  $path   Path to the config.
     * @param  string  $group  The items group.
     * @return bool            Successfully loaded.
     */
    public static function file(string $path, string $group = 'items')
    {
        // Check that the file exists before we attempt to load it.
        if (file_exists($path))
        {
            // Get items from the file.
            $items = include $path;

            // Items must be an array.
            if (is_array($items))
            {
                // Store items.
                foreach ($items as $key => $value)
                {
                    Repository::store($group, $key, $value);
                }

                // Successful file load.
                return true;
            }
            // Otherwise throw an exception.
            else
            {
                throw new Exception(sprintf(
                    'Config file <strong>%s</strong> is not a valid array.',
                $path));
            }
        }
        // File doesn't exist, throw exception.
        else
        {
            throw new Exception(sprintf(
                'Cannot load config from file, file <strong>%s</strong> does not exist.',
            $path));
        }

        // File load unsuccessful.
        return false;
    }

}
