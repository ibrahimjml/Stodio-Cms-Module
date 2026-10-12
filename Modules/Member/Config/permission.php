<?php

return [
    'module' => 'Member',
    'permissions' => [
        ['name' => 'members.view', 'description' => 'View members'],
        ['name' => 'members.create', 'description' => 'Create members'],
        ['name' => 'members.edit', 'description' => 'Edit members'],
        ['name' => 'members.delete', 'description' => 'Delete members'],
        ['name' => 'members.block', 'description' => 'Block or activate members'],
    ],
];
