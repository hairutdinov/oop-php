<?php

namespace App;

class PlayerEvent
{
    private TriggerEvent $name;
    /** @var callable */
    private $callback;

    public function __construct(TriggerEvent $name, callable $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    public function getName(): TriggerEvent
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }
}