<?php

namespace AppTest\integration\calculator;

use App\calculator\BirthdayCost;
use App\calculator\SimpleCost;
use App\CartItem;
use DateTime;

class BirthdayCostTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCostInBirthday()
    {
        $cost = new BirthdayCost(
            new SimpleCost(),
            new DateTime('1990-01-01'),
            new DateTime('2024-01-01'),
            10);
        $this->assertEquals(720, $cost->getCost([
            new CartItem(1, 2, 100),
            new CartItem(2, 3, 200),
        ]));
    }

    public function testGetCostNotInBirthday()
    {
        $cost = new BirthdayCost(
            new SimpleCost(),
            new DateTime('1990-01-01'),
            new DateTime('2024-01-02'),
            10);
        $this->assertEquals(800, $cost->getCost([
            new CartItem(1, 2, 100),
            new CartItem(2, 3, 200),
        ]));
    }
}