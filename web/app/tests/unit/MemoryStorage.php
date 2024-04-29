<?php

namespace AppTest\unit;
use App\CartItem;
use App\storage\StorageInterface;

class MemoryStorage implements StorageInterface
{
    /** @var CartItem[] $items */
    private $items = [];

    public function load(): array
    {
        return $this->items;
    }

    public function save(array $items)
    {
        $this->items = $items;
    }
}