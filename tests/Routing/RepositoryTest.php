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

        $this->assertInternalType('array', $stored);
        $this->assertArrayHasKey('controller', $stored);
        $this->assertArrayHasKey('action', $stored);

        Repository::store('post', 'login', [
            'controller'    => 'account',
            'action'        => 'login'
        ]);
        $stored = Repository::retrieve('post', 'login');

        $this->assertInternalType('array', $stored);
        $this->assertArrayHasKey('controller', $stored);
        $this->assertArrayHasKey('action', $stored);

        $stored = Repository::retrieve('get', 'notexist');

        $this->assertInternalType('array', $stored);
        $this->assertEmpty($stored);
    }

}
