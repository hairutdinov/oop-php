<?php

namespace App;

class PlayerEventCollection
{
    /** @var PlayerEvent[] */
    private array $collection = [];

    public function add(TriggerEvent $name, callable $callback)
    {
        $this->collection[] = new PlayerEvent($name, $callback);
    }

    public function remove(TriggerEvent $name, callable $callback)
    {
        foreach ($this->collection as $index => $item) {
            if ($item->getName() == $name && $item->getCallback() == $callback) {
                unset($this->collection[$index]);
            }
        }
    }

    public function iterator(TriggerEvent $name): \ArrayIterator
    {
        return new \ArrayIterator(
            array_filter(
                $this->collection,
                function (PlayerEvent $item) use ($name) {
                    return $item->getName() == $name;
                }
            )
        );
    }

    public function trigger(TriggerEvent $name, Player $player)
    {
        /** @var PlayerEvent $event */
        foreach ($this->iterator($name) as $event) {
            call_user_func($event->getCallback(), $player);
        }
    }
}