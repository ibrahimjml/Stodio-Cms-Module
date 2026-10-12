<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | The root PSR-4 namespace used for every module. This must match the
    | "Modules\\" entry mapped to the "path" below in the host app's composer.json.
    |
    */

    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Modules Path
    |--------------------------------------------------------------------------
    */

    'path' => base_path('Modules'),

    /*
    |--------------------------------------------------------------------------
    | Stubs Path
    |--------------------------------------------------------------------------
    |
    | Stub templates used by the "module:make*" generator commands. Publish them
    | (php artisan vendor:publish --tag=modules-stubs) to customize; any stub
    | missing here automatically falls back to the one bundled with the package.
    |
    */

    'stubs' => base_path('stubs/modules'),

    /*
    |--------------------------------------------------------------------------
    | Statuses File
    |--------------------------------------------------------------------------
    |
    | Tracks which modules are enabled or disabled. Modules are enabled by
    | default when no entry exists for them in this file.
    |
    */

    'statuses_file' => base_path('modules_statuses.json'),

];
