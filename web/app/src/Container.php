<?php

namespace App;

class Container
{
    private array $definitions = [];

    public function set(string $id, callable $callback): void
    {
        $this->definitions[$id] = $callback;
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new \Exception('Неизвестный компонент: ' . $id);
        }

        return call_user_func($this->definitions[$id], $this);
    }
}