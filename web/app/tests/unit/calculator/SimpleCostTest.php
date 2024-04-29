<?php

namespace AppTest\unit\calculator;

use App\calculator\SimpleCost;
use App\CartItem;

class SimpleCostTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCost()
    {
        $calculator = new SimpleCost();
        $this->assertEquals(800, $calculator->getCost([
            new CartItem(1, 1, 200),
            new CartItem(2, 2, 300),
        ]));
    }
}