<?php

return [
    // main modules - default CRUD actions
    'users' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'profile'],
    'employees' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'projects' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'clients' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'flats' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'flat-pricing-histories' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'incomes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'expenses' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'payment-methods' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'petty-cashes' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'audit-logs' => ['index', 'show'],

    // settings modules
    'departments' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'designations' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'expense-types' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'countries' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],

    // System commands module (actions are the specific commands)
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
];
