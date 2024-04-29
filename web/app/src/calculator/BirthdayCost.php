<?php

namespace App\calculator;

use App\CartItem;
use DateTime;

class BirthdayCost extends Cost
{
    private DateTime $birthDate;
    private DateTime $currentDate;
    private int $discountPercent;

    public function __construct(CalculatorInterface $calculator, DateTime $birthDate, DateTime $currentDate, int $discountPercent = 5)
    {
        $this->calculator = $calculator;
        $this->birthDate = $birthDate;
        $this->currentDate = $currentDate;
        $this->discountPercent = $discountPercent;
    }

    /**
     * @inheritDoc
     */
    public function getCost(array $items)
    {
        $cost = $this->calculator->getCost($items);
        if ($this->currentDate->format('m-d') == $this->birthDate->format('m-d')) {
            $cost *= (1 - $this->discountPercent / 100);
        }
        return $cost;
    }
}