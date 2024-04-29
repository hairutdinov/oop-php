<?php

namespace AppTest\integration\calculator;

use App\calculator\FourCost;
use App\calculator\SimpleCost;
use App\CartItem;

class FourCostTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCostFourItems()
    {
        $items = [
            new CartItem(1, 1, 100),
            new CartItem(2, 1, 100),
            new CartItem(3, 1, 100),
            new CartItem(4, 1, 100),
            new CartItem(5, 1, 100),
            new CartItem(6, 1, 100),
            new CartItem(7, 1, 100),
            new CartItem(8, 1, 100),
            new CartItem(9, 1, 100),
            new CartItem(10, 1, 100),
        ];
        $cost = new FourCost(new SimpleCost());
        $this->assertEquals(802, $cost->getCost($items));
    }
}