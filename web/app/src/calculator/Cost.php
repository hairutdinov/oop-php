<?php

namespace App\calculator;

use App\CartItem;

abstract class Cost implements CalculatorInterface
{
    protected CalculatorInterface $calculator;

    /**
     * @inheritDoc
     */
    abstract public function getCost(array $items);
}