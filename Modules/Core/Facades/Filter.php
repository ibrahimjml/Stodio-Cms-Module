<?php
namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void addListener(string|array|null $hook, string|array|\Closure $callback, int $priority = 20, int $arguments = 1)
 * @method static mixed fire(string $action, array $args = [])
 * @method static bool hasListeners(string $hook)
 * @method static array getListeners(string $hook)
 *
 * @see \Modules\Core\Support\ActionManager
 */
class Filter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'core.filter';
    }
}