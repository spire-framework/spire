<?php
namespace Spire\Template;

use Spire\Routing\ResponderInterface;
use Spire\Routing\Router;

class View implements ResponderInterface
{

    /**
     * @var string The view file.
     */
    protected $file = '';

    /**
     * @var array The view data.
     */
    protected $data = [];

    /**
     * Returns the view data.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function respond()
    {
        // Get the module action instance.
        $instance = Router::module()->instance();

        // If we have no layout, then directly output the view.
        if (is_object($instance) && isset($instance->layout) && $instance->layout === '')
        {
            echo $this->render();
        }
        // Otherwise add the view to the layout.
        else
        {
            Layout::view($this);
        }
    }

    /**
     * Render the view.
     *
     * @return string
     */
    public function render(): string
    {
        // Get path for the views.
        $path = Router::module()->path() . 'Views/' . $this->file . '.view.php';

        // Render the view.
        return Component::load($path, $this->data);
    }

    /**
     * Instantiates the view.
     *
     * @param  string  $file
     * @param  array   $data
     * @return \Spire\Template\View
     */
    public static function make(string $file, array $data = []): View
    {
        // Instantiate class.
        $name           = get_called_class();
        $class          = new $name;
        $class->file    = $file;
        $class->data    = $data;

        // Return new object.
        return $class;
    }

}
