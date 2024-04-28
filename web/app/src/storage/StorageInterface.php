<?php

namespace App\storage;

use App\CartItem;

interface StorageInterface
{
    /**
     * @return CartItem[]|array
     * */
    public function load(): array;

    /**
     * @param CartItem[] $items
     * */
    public function save(array $items);
}