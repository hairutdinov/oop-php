<?php

namespace App;

use App\storage\StorageInterface;

class Cart
{
    /** @var CartItem[] */
    private $items;
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getItems()
    {
        $this->loadItems();
        return $this->items;
    }

    public function add(int $id, int $count, float $price)
    {
        $this->loadItems();
        $currentCount = isset($this->items[$id]) ? $this->items[$id]->getCount() : 0;
        $this->items[$id] = new CartItem($id, $currentCount + $count, $price);
        $this->saveItems();
    }

    public function remove($id)
    {
        $this->loadItems();
        if (array_key_exists($id, $this->items)) {
            unset($this->items[$id]);
        }
        $this->saveItems();
    }

    public function clear()
    {
        $this->items = [];
        $this->saveItems();
    }

    public function getCost(): float
    {
        $this->loadItems();
        return array_reduce($this->items, function ($sum, CartItem $current) {
            return $sum + $current->getCost();
        });
    }

    private function loadItems()
    {
        if (is_null($this->items)) {
            $this->items = $this->storage->load();
        }
    }

    private function saveItems()
    {
        $this->storage->save($this->items);
    }
}