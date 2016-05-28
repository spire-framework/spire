<?php
namespace Spire\Session;

class SessionDriver
{

    /**
     * @var string  The session key name.
     */
    protected $key = 'spire';

    /**
     * Returns the array key used to store session data.
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

}
