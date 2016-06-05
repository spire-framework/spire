<?php
namespace Spire\Routing;

use Spire\Exception\Exception;

class Module
{

    /**
     * @var \Spire\Routing\Controller Controller instance.
     */
    protected $instance;

    /**
     * @var mixed The action response.
     */
    protected $response;

    /**
     * @var string The active module.
     */
    public $module = '';

    /**
     * @var string The active controller.
     */
    public $controller = '';

    /**
     * @var string The active action.
     */
    public $action = '';

    /**
     * @var string The active parameters.
     */
    public $parameters = [];

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value)
        {
            $this->$key = $value;
        }
    }

    /**
     * Returns the controller instance.
     *
     * @return \Spire\Routing\Controller
     */
    public function instance()
    {
        return $this->instance;
    }

    /**
     * Returns the module path.
     *
     * @return string
     */
    public function path(): string
    {
        return path('modules') . $this->module . '/';
    }

    /**
     * Runs the active controller action.
     *
     * @return mixed
     */
    public function run()
    {
        // Build the class name.
        $class = 'Modules\\' . $this->module . '\Controller\\' . $this->controller;

        // Ensure the class exists.
        if (class_exists($class))
        {
            // Instantiate class.
            $this->instance = new $class;
            $this->response = call_user_func_array([$this->instance, $this->action], $this->parameters);

            // Return the response.
            return $this->response;
        }
        // Otherwise throw an exception.
        else
        {
            throw new Exception(sprintf(
                'Controller <strong>%s</strong> does not exist.'
            , $class));
        }
    }

}
