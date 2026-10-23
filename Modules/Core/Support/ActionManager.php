<?php

namespace Modules\Core\Support;

use Closure;

abstract class ActionManager
{
    
    protected array $listeners = [];

    public function addListener(
        string|array|null $hook,
        string|array|Closure $callback,
        int $priority = 20,
        int $arguments = 1
    ): void {
        foreach ((array) $hook as $name) {
            $this->listeners[$name][$priority][] = [
                'callback'  => $callback,
                'arguments' => $arguments,
            ];
        }
    }

    public function getListeners(string $hook): array
    {
        $listeners = $this->listeners[$hook] ?? [];

        ksort($listeners, SORT_NUMERIC); // sort by priority

        return $listeners;
    }

    public function hasListeners(string $hook): bool
    {
        return ! empty($this->listeners[$hook]);
    }

    abstract public function fire(string $action, array $args): mixed;
}