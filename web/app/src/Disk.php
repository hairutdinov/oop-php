<?php

namespace App;

class Disk implements \Iterator
{
    /** @var Track[] */
    private array $collection;
    private int $position;

    /**
     * @var bool This variable indicates the traversal direction.
     */
    private $reverse = false;

    /**
     * @param Track[] $tracks
     */
    public function __construct(array $tracks)
    {
        $this->collection = $tracks;
        $this->position   = 0;
    }

    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function prev(): void
    {
        $this->position--;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}