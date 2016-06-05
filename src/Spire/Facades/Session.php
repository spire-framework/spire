<?php
namespace Spire\Facades;

use Spire\Session\Session as Factory;
use \Spire\Session\SessionDriver;
use \Spire\Session\SessionInterface;

class Session
{

    /**
     * @var SessionDriver The session class instance.
     */
    protected static $session;

    /**
     * Initializes the session.
     *
     * @return \Spire\Session\SessionDriver
     */
    public static function initialize()
    {
        return static::make();
    }

    /**
     * Finalizes the session.
     *
     * @return bool
     */
    public static function finalize(): bool
    {
        return static::make()->driver()->finalize();
    }

    /**
     * Inserts data into a session.
     *
     * @param  string  $name  The name of the session.
     * @param  mixed   $data  The data to add into the session.
     * @return \Spire\Session\SessionDriver
     */
    public static function put(string $name, $data): SessionDriver
    {
        return static::make()->driver()->put($name, $data);
    }

    /**
     * Gets data from a session.
     *
     * @param  string  $name  The name of the session.
     * @return \Spire\Session\SessionDriver
     */
    public static function get(string $name): SessionDriver
    {
        return static::make()->driver()->get($name);
    }

    /**
     * Checks if an item exists in session.
     *
     * @param  string  $name  The name of the session.
     * @return bool
     */
    public static function has(string $name): bool
    {
        return static::make()->driver()->has($name);
    }

    /**
     * Deletes an item from session.
     *
     * @param  string  $name  The name of the session.
     * @return \Spire\Session\SessionDriver
     */
    public function forget(string $name): SessionDriver
    {
        return static::make()->driver()->forget($name);
    }

    /**
     * Deletes all items from the session.
     *
     * @return \Spire\Session\SessionDriver
     */
    public function flush(): SessionDriver
    {
        return static::make()->driver()->flush();
    }

    /**
     * Returns all items in the session.
     *
     * @return array
     */
    public function all(): array
    {
        return static::make()->driver()->all();
    }

    /**
     * Sets flash data that only lives for one request, if no data was passed
     * it will attempt to find the stored data.
     *
     * @param  string  $name  The name of the flash data.
     * @param  array   $data  The data to store in the session.
     * @return mixed
     */
    public function flash(string $name, $data = null)
    {
        return static::make()->driver()->flash($name, $data);
    }

    /**
     * Keep flash data for another request.
     *
     * @param  string  $name  The name of the data to keep.
     * @return \Spire\Session\SessionDriver
     */
    public function keep(string $name): SessionDriver
    {
        return static::make()->driver()->keep($name);
    }

    /**
     * Returns the data kept for the next request.
     *
     * @return array
     */
    public function kept(): array
    {
        return static::make()->driver()->kept();
    }

    /**
     * Instantiates a new instance of the session class.
     *
     * @return \Spire\Session\Session
     */
    public static function make(): \Spire\Session\Session
    {
        return static::$session ?? new Factory;
    }

}
