<?php

use Spire\Http\Header as Header;

class HeaderTest extends PHPUnit_Framework_TestCase
{

    public function testSent()
    {
        $header = Header::sent();

        $this->assertTrue($header);
    }

    public function testGet()
    {
        $header = Header::get();

        $this->assertInternalType('array', $header);
    }

    public function testSend()
    {

    }

    public function testRemove()
    {
        
    }

}
