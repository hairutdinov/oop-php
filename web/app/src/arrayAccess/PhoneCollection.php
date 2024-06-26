<?php

namespace App\arrayAccess;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use JetBrains\PhpStorm\Internal\TentativeType;

class PhoneCollection implements \ArrayAccess, \Countable
{
    private array $phones;

    public function __construct(array $phones)
    {
        $this->phones = $phones;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->phones[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->phones[$offset] : null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($this->has($value)) {
            throw new \DomainException('Такой телефон уже есть в коллекции!');
        }
        if (is_null($offset)) {
            $this->phones[] = $value;
        } else {
            $this->phones[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->phones[$offset]);
        }
    }

    public function has(mixed $value)
    {
        return in_array($value, $this->phones);
    }

    public function count(): int
    {
        return count($this->phones);
    }
}