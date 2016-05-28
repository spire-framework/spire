<?php

use Spire\Config\Repository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers Repository
     */
    public function testRepository()
    {
        Repository::store('data', 'str', 'value');
        $stored = Repository::retrieve('data', 'str');

        $this->assertInternalType('string', $stored);
        $this->assertEquals('value', $stored);

        Repository::store('data', 'arr', ['key' => 'value']);
        $stored = Repository::retrieve('data', 'arr');

        $this->assertInternalType('array', $stored);
        $this->assertArrayHasKey('key', $stored);
        $this->assertEquals('value', $stored['key']);

        Repository::store('data', 'bool', true);
        $stored = Repository::retrieve('data', 'bool');

        $this->assertInternalType('bool', $stored);
        $this->assertTrue($stored);
    }

}
