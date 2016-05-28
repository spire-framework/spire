<?php

use Spire\Session\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{

    private $instance;

    public function setUp()
    {
        $this->instance = new Session;
    }

    public function tearDown()
    {
        unset($this->instance);
    }

    public function testDriver()
    {
        $this->assertInternalType('object', Session::driver());
    }

}
