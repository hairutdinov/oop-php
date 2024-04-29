<?php

namespace App;

class ContainerStructure
{
    private string $id;
    private $value;
    private bool $shared;

    public function __construct(string $id, mixed $value, bool $shared)
    {
        $this->id     = $id;
        $this->value  = $value;
        $this->shared = $shared;
    }

    public function isShared(): bool
    {
        return $this->shared;
    }

    /**
     * @return callable
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}