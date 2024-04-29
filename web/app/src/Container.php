<?php

namespace App;

use Exception;
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

    public function setShared(string $id, mixed $value): void
    {
        $this->shared[$id] = null;
        $this->definitions[] = new ContainerStructure($id, $value, true);
    }

    public function get(string $id)
    {
        if (isset($this->shared[$id])) {
            return $this->shared[$id];
        }


        if ($this->componentRegistered($id)) {
            /** @var ContainerStructure $component */
            $component = $this->getComponent($id);
            $id = $component->getId();
            $value = $component->getValue();
            $shared = $component->isShared();
        } else {
            $value = $id;
            $shared = false;
        }

        if (is_string($value) && class_exists($value)) {
            $reflection = new \ReflectionClass($value);
            $arguments = [];
            if ($constructor = $reflection->getConstructor()) {
                /** @var ReflectionParameter $parameter */
                foreach ($constructor->getParameters() as $parameter) {
                    if (($paramType = $parameter->getType())) {
                        $arguments[] = $this->get($paramType);
                    } else {
                        $arguments[] = null;
                    }
                }
            }
            $result = $reflection->newInstanceArgs($arguments);
        } elseif (is_callable($value)) {
            $result = call_user_func($value, $this);
        } elseif ($value instanceof $id) {
            $result = $value;
        }

        if (!isset($result)) {
            throw new Exception('Неизвестный компонент: ' . $id);
        }

        if ($shared) {
            $this->shared[$id] = $result;
        }

        return $result;
    }

    private function getIds(): ?array
    {
        if (empty($this->definitions)) {
            return [];
        }
        return array_map(fn (ContainerStructure $item) => $item->getId(), $this->definitions);
    }

    public function componentRegistered(string $id): bool
    {
        return in_array($id, $this->getIds());
    }

    private function getComponent(string $id): ?ContainerStructure
    {
        if (($index = array_search($id, $this->getIds())) === false) {
            return null;
        }
        return $this->definitions[$index];
    }
}