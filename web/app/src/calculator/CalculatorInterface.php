<?php

namespace App\calculator;

use App\CartItem;

interface CalculatorInterface
{
    /**
     * @param CartItem[] $items
     * @return float|int
     * */
    public function getCost(array $items); 
}