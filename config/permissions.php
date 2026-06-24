<?php

return [
    'superadmin' => [
        // main modules
        'users' => ['*'],
        'employees' => ['*'],
        'expenses' => ['*'],
        'petty-cashes' => ['*'],
        'audit-logs' => ['*'],

        // Domain accounting modules
        'clients' => ['*'],
        'projects' => ['*'],
        'flats' => ['*'],
        'flat-pricing-histories' => ['*'],
        'incomes' => ['*'],
        'payment-methods' => ['*'],

        // settings modules
        'departments' => ['*'],
        'designations' => ['*'],
        'expense-types' => ['*'],
        'countries' => ['*'],

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
        'users' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'profile'],
        'employees' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        // removed: sales, portal-balances, tours, visas, trainings
        'expenses' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'petty-cashes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'audit-logs' => ['index', 'show'],

        // Domain accounting modules
        'clients' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'projects' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'flats' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'flat-pricing-histories' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'incomes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'payment-methods' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],

        // settings modules
        'departments' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'designations' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'expense-types' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
        'countries' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    ],
    'staff' => [
        // main modules
        'users' => ['profile'],
        // 'employees' => ['index', 'show'],
        // 'expenses' => ['index', 'create', 'store', 'show', 'edit', 'update'],
        // 'petty-cashes' => ['index', 'create', 'store', 'show'],
        // 'audit-logs' => ['index', 'show'],

        // // settings modules
        // 'departments' => ['index', 'show'],
        // 'designations' => ['index', 'show'],
    ],
];

// @canany(['users.*']) ... @endcanany // this is for permission assign with * like 'users' => ['*'].

// @canany(['users.create']) ... @endcanany // this is for permission assign with create permission like 'users' => ['create'].

// @canany(['users.create', 'posts.create']) ... @endcanany // this is for permission assign with create permission like 'users' => ['create'] and 'posts' => ['create'].
