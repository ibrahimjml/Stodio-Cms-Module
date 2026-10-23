<?php

namespace Modules\Core\Support;

class Action extends ActionManager
{
	public function fire(string $action, array $args): mixed
    {
         if (! $this->hasListeners($action)) {
              return null;
         }

          foreach ($this->getListeners($action) as $listeners) {
              foreach ($listeners as $listener) {
                  call_user_func_array(
                      $listener['callback'],
                      array_slice($args, 0, $listener['arguments'])
                  );
              }
          }

       return null;
     }
}