<?php

use Spire\Routing\Route;

class RouteTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $route = Route::get('account/preferences', [
            'controller'    => 'Account',
            'action'        => 'preferences'
        ]);
        $this->assertTrue($route);

        $route = Route::get('account/preferences', []);
        $this->assertFalse($route);

        $route = Route::get('account/preferences', ['controller' => 'Account']);
        $this->assertFalse($route);

        $route = Route::get('account/preferences', ['action' => 'preferences']);
        $this->assertFalse($route);
    }

    public function testPost()
    {
        $route = Route::post('account/preferences', [
            'controller'    => 'Account',
            'action'        => 'preferences'
        ]);
        $this->assertTrue($route);

        $route = Route::post('account/preferences', []);
        $this->assertFalse($route);

        $route = Route::post('account/preferences', ['controller' => 'Account']);
        $this->assertFalse($route);

        $route = Route::post('account/preferences', ['action' => 'preferences']);
        $this->assertFalse($route);
    }

}
