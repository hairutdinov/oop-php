<?php

namespace App\calculator;

use App\CartItem;
use DateTime;

class FourCost extends Cost
{
    public function __construct(CalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @inheritDoc
     */
    public function getCost(array $items)
    {
        $cost = $this->calculator->getCost($items);
        $k = 1;
        /** @var CartItem $item */
        foreach ($items as $item) {
            if ($k % 4 == 0) {
                $cost -= $item->getCost() - 1;
            }
            $k++;
        }
        return $cost;
    }
}