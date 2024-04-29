<?php

namespace App;

class ContainerStructure
{
    private string $id;
    private $callback;
    private bool $shared;

    public function __construct(string $id, callable $callback, bool $shared)
    {
        $this->id = $id;
        $this->callback = $callback;
        $this->shared = $shared;
    }

    public function isShared(): bool
    {
        return $this->shared;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}