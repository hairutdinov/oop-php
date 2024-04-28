<?php

namespace App\storage;

class SessionStorage implements StorageInterface
{
    private string $sessionKey;

    public function __construct(string $sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * @inheritdoc
     * */
    public function load(): array
    {
        return isset($_SESSION[$this->sessionKey]) ? unserialize($_SESSION[$this->sessionKey]) : [];
    }

    /**
     * @inheritdoc
     * */
    public function save(array $items)
    {
        $_SESSION[$this->sessionKey] = serialize($items);
    }
}