<?php

return [
    // main modules - default CRUD actions
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
