<?php

namespace AppTest\integration\calculator;

use App\calculator\NewYearCost;
use App\calculator\SimpleCost;
use App\CartItem;
use DateTime;

class NewYearCostTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCostInDecemberYear()
    {
        $newYearCost = new NewYearCost(new SimpleCost(), new DateTime('2023-12-01'), 5);
        $this->assertEquals(760, $newYearCost->getCost([
            new CartItem(1, 2, 100),
            new CartItem(2, 3, 200),
        ]));
    }

    public function testGetCostInJune()
    {
        $newYearCost = new NewYearCost(new SimpleCost(), new DateTime('2023-06-01'), 5);
        $this->assertEquals(800, $newYearCost->getCost([
            new CartItem(1, 2, 100),
            new CartItem(2, 3, 200),
        ]));
    }
}