<?php

return [
    'module' => 'ModuleManagement',
    'permissions' => [
        ['name' => 'modules.view', 'description' => 'View modules'],
        ['name' => 'modules.migrate', 'description' => 'Run module migrations'],
        ['name' => 'modules.activate', 'description' => 'Activate or deactivate modules'],
        ['name' => 'modules.delete', 'description' => 'Delete modules'],
    ],
];
