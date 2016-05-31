<?php

use Spire\Http\Uri;

class UriTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        Uri::initialize();
    }

    public function testInitialize()
    {

    }

    public function testBase()
    {
        $uri = Uri::base();

        $this->assertInternalType('string', $uri);
    }

    public function testUri()
    {
        $uri = Uri::uri();

        $this->assertInternalType('string', $uri);
    }

    public function testSegments()
    {
        $uri = Uri::segments();

        $this->assertInternalType('array', $uri);
    }

    public function testUrl()
    {
        $uri = Uri::url();

        $this->assertInternalType('string', $uri);
    }

    public function testSegment()
    {

    }

    public function testSegmentString()
    {
        $uri = Uri::segmentString();

        $this->assertInternalType('string', $uri);
    }

}
