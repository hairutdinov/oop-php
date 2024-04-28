<?php

namespace App\storage;

use App\CartItem;

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
        if (!isset($_SESSION[$this->sessionKey])) {
            return [];
        }
        $items = unserialize($_SESSION[$this->sessionKey]);
        return array_combine(array_map(function (CartItem $item) { return $item->getId(); }, $items), $items);
    }

    /**
     * @inheritdoc
     * */
    public function save(array $items)
    {
        $_SESSION[$this->sessionKey] = serialize($items);
    }
}