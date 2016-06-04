<?php

use Spire\Routing\Repository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers Repository
     */
    public function testRepository()
    {
        Repository::store('get', 'about', [
            'controller'    => 'pages',
            'action'        => 'about'
        ]);
        $stored = Repository::retrieve('get', 'about');
        $removed = Repository::remove('get', 'about');

        $this->assertInternalType('array', $stored);
        $this->assertArrayHasKey('controller', $stored);
        $this->assertArrayHasKey('action', $stored);
        $this->assertTrue($removed);

        Repository::store('post', 'login', [
            'controller'    => 'account',
            'action'        => 'login'
        ]);
        $stored = Repository::retrieve('post', 'login');
        $removed = Repository::remove('post', 'login');

        $this->assertInternalType('array', $stored);
        $this->assertArrayHasKey('controller', $stored);
        $this->assertArrayHasKey('action', $stored);
        $this->assertTrue($removed);

        $stored = Repository::retrieve('get', 'notexist');
        $removed = Repository::remove('get', 'notexist');

        $this->assertInternalType('array', $stored);
        $this->assertEmpty($stored);
        $this->assertFalse($removed);
    }

}
