<?php 

use Modules\Core\Facades\Action;
use Modules\Core\Facades\Filter;

if (! function_exists('add_filter')) {
    function add_filter(
    	 string|array|null $hook,
    	 string|array|Closure $callback,
    	 int $priority = 20, 
    	 int $arguments = 1): void
    {
        Filter::addListener($hook, $callback, $priority, $arguments);
    }
}

if (! function_exists('apply_filter')) {
    function apply_filter(string $hook, mixed $value, mixed ...$args): mixed
    {
        return Filter::fire($hook, [$value, ...$args]);
    }
}
if (! function_exists('add_action')) {
    function add_action(
        string|array|null $hook,
        string|array|Closure $callback,
        int $priority = 20,
        int $arguments = 1
    ): void {
        Action::addListener($hook, $callback, $priority, $arguments);
    }
}

if (! function_exists('apply_action')) {
    function apply_action(string $action, mixed ...$args): void
    {
        Action::fire($action, $args);
    }
}

if (! function_exists('do_action')) {
    function do_action(string $action, mixed ...$args): void
    {
        Action::fire($action, $args);
    }
}