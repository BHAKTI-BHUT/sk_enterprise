<?php

return [
    'modules' => [
        'User Management' => [
            'view user',
            'create user',
            'edit user',
            'delete user',
        ],
        'Role Management' => [
            'view role',
            'create role',
            'edit role',
            'delete role',
        ],
        'Permission Management' => [
            'view permission',
            'create permission',
            'edit permission',
            'delete permission',
        ],
        'Dashboard' => [
            'view dashboard',
        ],
        'Product Management' => [
            'view product',
            'create product',
            'edit product',
            'delete product',
        ],
        'Brand Management' => [
            'view brand',
            'create brand',
            'edit brand',
            'delete brand',
        ],
        'Category Management' => [
            'view category',
            'create category',
            'edit category',
            'delete category',
        ],
    ],
    'roles' => [
        'Admin' => [
            'User Management',
            'Role Management',
            'Permission Management',
            'Dashboard',
            'Product Management',
            'Brand Management',
            'Category Management',
        ],
        'Employee' => [
            'Dashboard',
        ],
    ]
];
