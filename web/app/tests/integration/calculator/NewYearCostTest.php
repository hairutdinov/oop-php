<?php

namespace AppTest\integration\calculator;

use App\calculator\NewYearCost;
use App\calculator\SimpleCost;
use App\CartItem;
use AppTest\integration\DummyCost;
use DateTime;

class NewYearCostTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCostInDecemberYear()
    {
        $newYearCost = new NewYearCost(new DummyCost(800), new DateTime('2023-12-01'), 5);
        $this->assertEquals(760, $newYearCost->getCost([]));
    }

    public function testGetCostInJune()
    {
        $newYearCost = new NewYearCost(new DummyCost(800), new DateTime('2023-06-01'), 5);
        $this->assertEquals(800, $newYearCost->getCost([]));
    }
}