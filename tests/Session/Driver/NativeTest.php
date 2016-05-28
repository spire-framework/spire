<?php

use Spire\Session\Driver\Native as Session;

class NativeTest extends PHPUnit_Framework_TestCase
{

    private $instance;

    public function setUp()
    {
        $this->instance = new Session;

        // We can't start a session within PHPUnit so create a mock value.
        $_SESSION = [$this->instance->key() => [], 'flash' => []];
    }

    public function tearDown()
    {
        unset($this->instance, $_SESSION);
    }

    public function testInitialize()
    {
        $session = $this->instance->initialize();

        $this->assertInternalType('boolean', $session);
    }

    public function testFinalize()
    {
        $session = $this->instance->finalize();

        $this->assertInternalType('boolean', $session);
    }

    public function testPut()
    {
        $session = $this->instance->put('mysessionname', 'testdata');

        $this->assertArrayHasKey('mysessionname', $_SESSION[$this->instance->key()]);
        $this->assertEquals($_SESSION[$this->instance->key()]['mysessionname'], 'testdata');
        $this->assertInternalType('object', $session);
    }

    public function testGet()
    {
        $this->instance->put('mysessionname', 'testdata');
        $session = $this->instance->get('mysessionname', 'testdata');

        $this->assertEquals($session, 'testdata');
        $this->assertInternalType('string', $session);

        $this->instance->put('mysessionname', ['test' => 'data']);
        $session = $this->instance->get('mysessionname', 'testdata');

        $this->assertArrayHasKey('test', $session);
        $this->assertInternalType('array', $session);
    }

    public function testForget()
    {
        $session = $this->instance->has('mysessionname');

        $this->assertInternalType('bool', $session);
        $this->assertFalse($session);

        $this->instance->put('mysessionname', 'testdata');
        $session = $this->instance->has('mysessionname');

        $this->assertInternalType('bool', $session);
        $this->assertTrue($session);
    }

    public function testFlush()
    {
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);
        $this->assertEmpty($session);

        $this->instance->put('mysessionname', 'testdata');
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);
        $this->assertCount(1, $session);

        $this->instance->flush();
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);
        $this->assertEmpty($session);
    }

    public function testAll()
    {
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);
        $this->assertEmpty($session);

        $this->instance->put('mysessionname', 'testdata');
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);
        $this->assertCount(1, $session);
    }

    public function testFlash()
    {
        $session = $this->instance->flash('mysessionname');

        $this->assertFalse($session);

        $session = $this->instance->flash('mysessionname', 'testdata');

        $this->assertInternalType('string', $session);
        $this->assertArrayHasKey('mysessionname', $_SESSION['flash']);

        $session = $this->instance->flash('mysessionname');

        $this->assertInternalType('string', $session);
        $this->assertEquals($session, 'testdata');
        $this->assertContains('mysessionname', $this->instance->kept());
    }

    public function testKeep()
    {
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);

        $this->instance->put('mysessionname', 'testdata');
        $session = $this->instance->all();

        $this->assertInternalType('array', $session);
        $this->assertArrayHasKey('mysessionname', $session);
    }

    public function testKept()
    {
        $this->instance->flash('mysessionname', 'testdata');
        $session = $this->instance->kept();

        $this->assertInternalType('array', $session);
        $this->assertContains('mysessionname', $session);
    }

}
