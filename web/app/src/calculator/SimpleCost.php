<?php

namespace App\calculator;

use App\CartItem;

class SimpleCost implements CalculatorInterface
{
    /**
     * @inheritDoc
     */
    public function getCost(array $items)
    {
        return array_reduce($items, function ($sum, CartItem $current) {
            return $sum + $current->getCost();
        });
    }
}