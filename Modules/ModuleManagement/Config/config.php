<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Excluded Modules
    |--------------------------------------------------------------------------
    |
    | Modules listed here are treated as always active system modules. They
    | cannot be deactivated from the "Modules" page in the admin panel and are
    | excluded from the activated modules list stored in the settings table.
    |
    */
    'enabled_modules_manager' => env('MODULES_MANAGER_ENABLED', true),
    
    'excluded_modules' => [
        'Core',
        'Acl',
        'Member',
        'Admin',
        'ModuleManagement',
    ],

];
