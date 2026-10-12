<?php

return [
    'module' => 'Acl',
    'permissions' => [
        ['name' => 'acl.users.view', 'description' => 'View admin users'],
        ['name' => 'acl.users.create', 'description' => 'Create admin users'],
        ['name' => 'acl.users.edit', 'description' => 'Edit admin users'],
        ['name' => 'acl.users.delete', 'description' => 'Delete admin users'],
        ['name' => 'acl.roles.view', 'description' => 'View roles'],
        ['name' => 'acl.roles.create', 'description' => 'Create roles'],
        ['name' => 'acl.roles.edit', 'description' => 'Edit roles'],
        ['name' => 'acl.roles.delete', 'description' => 'Delete roles'],
        ['name' => 'acl.permissions.view', 'description' => 'View permissions'],
        ['name' => 'acl.permissions.create', 'description' => 'Create permissions'],
        ['name' => 'acl.permissions.edit', 'description' => 'Edit permissions'],
        ['name' => 'acl.permissions.delete', 'description' => 'Delete permissions'],
    ],
];
