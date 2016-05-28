<?php

use Spire\Config\Config;
use Spire\Config\Repository;

class ConfigTest extends PHPUnit_Framework_TestCase
{

    public function testStore()
    {
        Repository::store('items', 'item', 'value');
        $config = Config::item('item');

        $this->assertInternalType('string', $config);
        $this->assertEquals('value', $config);
    }

}
