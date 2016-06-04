<?php
namespace Spire\Routing;

class Route
{

    /**
     * @var string The module we're setting routes for.
     */
    public static $module;

    /**
     * Sets a GET route.
     *
     * @param  string  $uri      The URI to route.
     * @param  string  $options  The route options.
     * @return bool
     */
    public static function get(string $uri, array $options): bool
    {
        if (static::validateOptions($options))
        {
            // Set module.
            if (!isset($options['module'])) $options['module'] = static::$module;

            // Set route.
            Repository::store('get', $uri, $options);
            return true;
        }

        return false;
    }

    /**
     * Sets a POST route.
     *
     * @param  string  $uri      The URI to route.
     * @param  string  $options  The route options.
     * @return bool
     */
     public static function post(string $uri, array $options): bool
     {
         if (static::validateOptions($options))
         {
             // Set module.
             if (!isset($options['module'])) $options['module'] = static::$module;

             // Set route.
             Repository::store('post', $uri, $options);
             return true;
         }

         return false;
     }

     /**
      * Validates the route options.
      *
      * @param  array  $options  Route options to validate.
      * @return bool
      */
     private static function validateOptions(array $options): bool
     {
         return isset($options['controller'], $options['action']);
     }

}
