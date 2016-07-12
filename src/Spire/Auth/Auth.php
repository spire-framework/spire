<?php
namespace Spire\Auth;

use Spire\Config\Config;
use Spire\Encryption\Hash;
use Spire\Facades\Session;
use Spire\Orm\Model;

class Auth implements AuthInterface
{

    /**
     * @var bool User authenticated?
     */
    protected static $authorized = false;

    /**
     * @var \Spire\Orm\Model The authenticated user.
     */
    protected static $user;

    /**
     * Instantiate the auth class.
     *
     * @return void
     */
    public static function initialize()
    {
        // Load the auth config.
        $loaded = Config::file(path('config') . 'auth.php', 'auth');

        // If no config was loaded, show an error.
        if (!$loaded)
        {
            exit('Unable to load auth config.');
        }

        // Check if we have a user logged in.
        if (
            Session::has('auth.user') &&
            Session::has('auth.authorized')
        )
        {
            static::$authorized = Session::get('auth.authorized');
            static::$user       = Session::get('auth.user');
        }
    }

    /**
     * Is the user authorized?
     *
     * @return bool
     */
    public static function authorized(): bool
    {
        return static::$authorized;
    }

    /**
     * Returns the authenticated user.
     *
     * @return \Spire\Orm\Model
     */
    public static function user(): Model
    {
        return static::$user;
    }

    /**
     * Authorize a user.
     *
     * @param  \Spire\Orm\Model  $user  The user to authorize.
     * @return void
     */
    public static function authorize(\Spire\Orm\Model $user)
    {
        Session::put('auth.authorized', true);
        Session::put('auth.user', $user);

        static::$authorized = true;
        static::$user       = $user;
    }

    /**
     * Unauthorizes current user.
     *
     * @return void
     */
    public static function unauthorize()
    {
        Session::forget('auth.authorized');
        Session::forget('auth.user');

        static::$authorized = false;
        static::$user       = null;
    }

    /**
     * Get the username field name.
     *
     * @return string.
     */
    public static function usernameField(): string
    {
        return Config::item('username', 'auth');
    }

    /**
     * Get the password field name.
     *
     * @return string.
     */
    public static function passwordField(): string
    {
        return Config::item('password', 'auth');
    }

    /**
     * Generates a new random password salt.
     *
     * @return int
     */
    public static function salt(): string
    {
        return (string) rand(10000000, 99999999);
    }

    /**
     * Encrypts a password.
     *
     * @param  string  $password  The password to encrypt.
     * @param  string  $salt      The password salt.
     * @return string
     */
    public static function encryptPassword(string $password, string $salt = ''): string
    {
        return Hash::make($password . $salt, 'sha256');
    }

}
