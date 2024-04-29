<?php

namespace AppTest\integration;

use App\calculator\CalculatorInterface;
use App\CartItem;

class DummyCost implements CalculatorInterface
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getCost(array $items = [])
    {
        return $this->value;
    }
}