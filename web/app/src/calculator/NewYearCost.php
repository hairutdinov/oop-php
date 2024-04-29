<?php

namespace App\calculator;

use App\CartItem;
use DateTime;

class NewYearCost extends Cost
{
    private DateTime $date;
    private int $discountPercent;

    public function __construct(CalculatorInterface $calculator, DateTime $date, int $discountPercent = 5)
    {
        $this->calculator = $calculator;
        $this->date = $date;
        $this->discountPercent = $discountPercent;
    }

    /**
     * @inheritDoc
     */
    public function getCost(array $items)
    {
        $cost = $this->calculator->getCost($items);
        if ($this->date->format('m') == 12) {
            $cost *= (1 - $this->discountPercent / 100);
        }
        return $cost;
    }
}