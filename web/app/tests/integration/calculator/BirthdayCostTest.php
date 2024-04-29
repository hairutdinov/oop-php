<?php

namespace AppTest\integration\calculator;

use App\calculator\BirthdayCost;
use AppTest\integration\DummyCost;
use DateTime;

class BirthdayCostTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCostInBirthday()
    {
        $cost = new BirthdayCost(
            new DummyCost(800),
            new DateTime('1990-01-01'),
            new DateTime('2024-01-01'),
            10);
        $this->assertEquals(720, $cost->getCost([]));
    }

    public function testGetCostNotInBirthday()
    {
        $cost = new BirthdayCost(
            new DummyCost(800),
            new DateTime('1990-01-01'),
            new DateTime('2024-01-02'),
            10);
        $this->assertEquals(800, $cost->getCost([]));
    }
}