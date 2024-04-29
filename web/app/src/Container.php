<?php

namespace App;

class Container
{
    private array $definitions = [];
    private array $shared = [];

    public function set(string $id, callable $callback): void
    {
        $this->shared[$id] = null;
        $this->definitions[] = new ContainerStructure($id, $callback, false);
    }

    public function setShared(string $id, callable $callback): void
    {
        $this->shared[$id] = null;
        $this->definitions[] = new ContainerStructure($id, $callback, true);
    }

    public function get(string $id)
    {
        if (isset($this->shared[$id])) {
            return $this->shared[$id];
        }

        if (!$this->componentRegistered($id)) {
            throw new \Exception('Неизвестный компонент: ' . $id);
        }

        /** @var ContainerStructure $component */
        $component = $this->getComponent($id);
        $result = call_user_func($component->getCallback(), $this);

        if ($component->isShared()) {
            $this->shared[$id] = $result;
        }

        return $result;
    }

    private function getIds(): ?array
    {
        if (empty($this->definitions)) {
            return [];
        }
        return array_map(function (ContainerStructure $item) {
            return $item->getId();
        }, $this->definitions);
    }

    public function componentRegistered(string $id): bool
    {
        return in_array(
            $id,
            $this->getIds()
        );
    }

    private function getComponent(string $id): ?ContainerStructure
    {
        $index = array_search($id, $this->getIds());
        if ($index === false) {
            return null;
        }
        return $this->definitions[$index];
    }
}