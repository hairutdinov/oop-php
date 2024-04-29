<?php

namespace App;

class CartItem
{
    private int $id;
    private int $count;
    private float $price;

    public function __construct(int $id, int $count, float $price)
    {
        $this->id = $id;
        $this->count = $count;
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCost(): ?float
    {
        return $this->price * $this->count;
    }

}