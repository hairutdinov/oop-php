<?php

namespace App\iterator;

use Exception;
use JetBrains\PhpStorm\Internal\TentativeType;
use Traversable;

class PhoneCollection2 implements \IteratorAggregate
{
    private array $phones;

    public function __construct(array $phones)
    {
        $this->phones = $phones;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->phones);
    }
}