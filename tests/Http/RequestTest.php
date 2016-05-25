<?php

use Spire\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerIs
     */
    public function testIs($method)
    {
        $request = Request::is($method);

        $this->assertInternalType('boolean', $request);
    }

    public function providerIs(): array
    {
        return [
            ['https'],
            ['cli'],
            ['ajax'],
            ['post'],
            ['get'],
            ['something']
        ];
    }

    public function testMethod()
    {
        $request = Request::method();

        $this->assertInternalType('string', $request);
    }

    public function testHttps()
    {
        $request = Request::https();

        $this->assertInternalType('boolean', $request);
    }

    public function testAjax()
    {
        $request = Request::ajax();

        $this->assertInternalType('boolean', $request);
    }

    public function testCli()
    {
        $request = Request::cli();

        $this->assertInternalType('boolean', $request);
    }

}
