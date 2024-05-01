<?php

namespace App\iterator;

class PhoneCollection implements \Iterator
{
    private array $phones;

    public function __construct(array $phones)
    {
        $this->phones = $phones;
    }

    public function current(): mixed
    {
        return current($this->phones);
    }

    public function next(): void
    {
        next($this->phones);
    }

    public function key(): mixed
    {
        return key($this->phones);
    }

    public function valid(): bool
    {
        return !is_null(key($this->phones));
    }

    public function rewind(): void
    {
        reset($this->phones);
    }
}