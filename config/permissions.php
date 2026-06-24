<?php

return [
    'superadmin' => [
        // main modules
        'users' => ['*'],
        'employees' => ['*'],
        'sales' => ['*'],
        'portal-balances' => ['*'],
        'tours' => ['*'],
        'visas' => ['*'],
        'trainings' => ['*'],
        'expenses' => ['*'],
        'petty-cashes' => ['*'],
        'audit-logs' => ['*'],

        // settings modules
        'departments' => ['*'],
        'designations' => ['*'],
        'portals' => ['*'],
        'training-types' => ['*'],
        'service-types' => ['*'],
        'airlines' => ['*'],
        'flight-types' => ['*'],
        'trips' => ['*'],
        'purposes' => ['*'],
        'visa-purposes' => ['*'],
        'countries' => ['*'],
        'infos' => ['*'],

        // System commands module
        'system' => [
            'link-storage',
            'link-storage-external',
            'clear-cache',
            'clear-config-cache',
            'cache-config',
            'clear-route-cache',
            'cache-routes',
            'clear-view-cache',
            'cache-views',
            'migrate',
            'rollback-migration',
            'seed',
            'restart-queue',
            'clear-event-cache',
            'cache-events',
            'composer-optimize',
            'composer-dump-autoload',
        ],
    ],
    'admin' => [
        // main modules
        'users' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete', 'profile'],
        'employees' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'sales' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'portal-balances' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'tours' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'visas' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'trainings' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'expenses' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'petty-cashes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'audit-logs' => ['index', 'show'],

        // settings modules
        'departments' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'designations' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'portals' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'training-types' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'service-types' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'airlines' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'flight-types' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'trips' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'purposes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'visa-purposes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'countries' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
        'infos' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'force-delete'],
    ],
    'staff' => [
        // main modules
        'users' => ['profile'],
        // 'employees' => ['index', 'show'],
        // 'sales' => ['index', 'create', 'store', 'show', 'edit', 'update'],
        // 'portal-balances' => ['index', 'show'],
        // 'tours' => ['index', 'create', 'store', 'show', 'edit', 'update'],
        // 'visas' => ['index', 'create', 'store', 'show', 'edit', 'update'],
        // 'trainings' => ['index', 'create', 'store', 'show', 'edit', 'update'],
        // 'expenses' => ['index', 'create', 'store', 'show', 'edit', 'update'],
        // 'petty-cashes' => ['index', 'create', 'store', 'show'],
        // 'audit-logs' => ['index', 'show'],

        // // settings modules
        // 'departments' => ['index', 'show'],
        // 'designations' => ['index', 'show'],
        // 'portals' => ['index', 'show'],
        // 'training-types' => ['index', 'show'],
        // 'service-types' => ['index', 'show'],
        // 'airlines' => ['index', 'show'],
        // 'flight-types' => ['index', 'show'],
        // 'trips' => ['index', 'show'],
        // 'purposes' => ['index', 'show'],
        // 'visa-purposes' => ['index', 'show'],
        // 'countries' => ['index', 'show'],
        // 'infos' => ['index', 'show'],
        // 'expense-categories' => ['index', 'show'],
    ],
];

// @canany(['users.*']) ... @endcanany // this is for permission assign with * like 'users' => ['*'].

// @canany(['users.create']) ... @endcanany // this is for permission assign with create permission like 'users' => ['create'].

// @canany(['users.create', 'posts.create']) ... @endcanany // this is for permission assign with create permission like 'users' => ['create'] and 'posts' => ['create'].
