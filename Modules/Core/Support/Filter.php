<?php

namespace Modules\Core\Support;

class Filter extends ActionManager
{
    public function fire(string $action, array $args = []): mixed
    {
        $value = $args[0] ?? null;

        if (! $this->hasListeners($action)) {
            return $value;
        }

        foreach ($this->getListeners($action) as $listeners) {
            foreach ($listeners as $listener) {
                $params = array_slice([$value, ...array_slice($args, 1)], 0, $listener['arguments']);
                $value  = call_user_func_array($listener['callback'], $params);
            }
        }

        return $value;
    }
}