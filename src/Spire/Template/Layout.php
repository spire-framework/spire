<?php
namespace Spire\Template;

use Spire\Facades\Session;

class Layout
{

    /**
     * @var array Layout view data.
     */
    protected static $data = [];

    /**
     * @var \Spire\Template\View The layout view object.
     */
    protected static $view;

    /**
     * Gets the layout data.
     *
     * @return array
     */
    public static function data(): array
    {
        return static::$data;
    }

    /**
     * Sets layout data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public static function set(string $key, $value)
    {
        static::$data[$key] = $value;
    }

    /**
     * Gets a layout.
     *
     * @param  string  $name
     * @param  array   $data
     * @return string
     */
    public static function get(string $name, array $data = []): string
    {
        // Merge the data.
        static::$data = array_merge_recursive(static::data(), $data);

        // Merge validation errors into the view data.
        if (!isset(static::$data['errors']) && $errors = Session::flash('validation_errors'))
        {
            static::$data['errors'] = $errors;
        }

        // Get the path to the layout.
        $path = path('layouts') . $name . '.layout.php';

        // Load.
        return Component::load($path, static::data());
    }

    /**
     * Add main view to the layout.
     *
     * @param  \Spire\Template\View  $view
     * @return void
     */
    public static function view(\Spire\Template\View $view)
    {
        foreach ($view->data() as $key => $value)
        {
            static::set($key, $value);
        }

        static::$view = $view;
    }

    /**
     * Loads the main view content.
     *
     * @return string
     */
    public static function content(): string
    {
        if (is_object(static::$view))
        {
            return static::$view->render();
        }
        else
        {
            return '';
        }
    }

}
