<?php

namespace AppTest\integration\calculator;

use App\calculator\BirthdayCost;
use AppTest\integration\DummyCost;
use DateTime;

class BirthdayCostTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getDates
     * */
    public function testGetCost($birthDate, $currentDate, $expectedCost)
    {
        $cost = new BirthdayCost(
            new DummyCost(800),
            new DateTime($birthDate),
            new DateTime($currentDate),
            10);
        $this->assertEquals($expectedCost, $cost->getCost([]));
    }

    public function getDates()
    {
        return [
            'birthday' => ['1990-01-01', '2024-01-01', 720],
            'not-a-birthday' => ['1990-01-01', '2024-01-02', 800],
        ];
    }
}