<?php

namespace App;

use ReflectionParameter;

class Container
{
    private array $definitions = [];
    private array $shared = [];

    public function set(string $id, mixed $value): void
    {
        $this->shared[$id] = null;
        $this->definitions[] = new ContainerStructure($id, $value, false);
    }

    public function setShared(string $id, mixed $callback): void
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
        $value = $component->getValue();

        if (is_string($value)) {
            $reflection = new \ReflectionClass($value);
            $arguments = [];
            if ($constructor = $reflection->getConstructor()) {
                /** @var ReflectionParameter $parameter */
                foreach ($constructor->getParameters() as $parameter) {
                    if (($paramType = $parameter->getType())) {
                        $arguments[] = $this->get($paramType);
                    }
                }
            }
            $result = $reflection->newInstanceArgs($arguments);
        } elseif (is_callable($value)) {
            $result = call_user_func($value, $this);
        } elseif (is_object($value)) {
            $result = $value;
        }

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