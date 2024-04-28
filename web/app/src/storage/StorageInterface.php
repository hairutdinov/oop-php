<?php

namespace App\storage;

use App\CartItem;

interface StorageInterface
{
    /**
     * @return array<CartItem>|array
     * */
    public function load(): array;

    /**
     * @param array<CartItem> $items
     * */
    public function save(array $items);
}