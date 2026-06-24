<?php

return [
    'sections' => [
        'Organize and Manage' => [
            ['module' => 'sales', 'route' => 'sales.index', 'icon' => 'fas fa-file-invoice-dollar mr15', 'label' => 'Ticket Sales'],
            ['module' => 'tours', 'route' => 'tours.index', 'icon' => 'fas fa-suitcase mr15', 'label' => 'Tours'],
            ['module' => 'portal-balances', 'route' => 'portal-balances.index', 'icon' => 'fas fa-wallet mr15', 'label' => 'Portal Balances'],
            ['module' => 'visas', 'route' => 'visas.index', 'icon' => 'fas fa-passport mr15', 'label' => 'VISA & Consultency'],
            ['module' => 'trainings', 'route' => 'trainings.index', 'icon' => 'fas fa-graduation-cap mr15', 'label' => 'Trainings'],
            ['module' => 'expenses', 'route' => 'expenses.index', 'icon' => 'fas fa-money-check-alt mr15', 'label' => 'Expenses'],
            ['module' => 'petty-cashes', 'route' => 'petty-cashes.index', 'icon' => 'fas fa-wallet mr15', 'label' => 'Petty Cash'],
            ['module' => 'clients', 'route' => 'clients.index', 'icon' => 'fas fa-user-tie mr15', 'label' => 'Clients'],
            ['module' => 'projects', 'route' => 'projects.index', 'icon' => 'fas fa-project-diagram mr15', 'label' => 'Projects'],
            ['module' => 'flats', 'route' => 'flats.index', 'icon' => 'fas fa-building mr15', 'label' => 'Flats'],
            ['module' => 'incomes', 'route' => 'incomes.index', 'icon' => 'fas fa-hand-holding-dollar mr15', 'label' => 'Incomes'],
            ['module' => 'flat-pricing-histories', 'route' => 'flat-pricing-histories.index', 'icon' => 'fas fa-history mr15', 'label' => 'Flat Pricing'],
        ],

        'Settings' => [
            ['module' => 'portals', 'route' => 'portals.index', 'icon' => 'fas fa-table mr15', 'label' => 'Portals'],
            ['module' => 'training-types', 'route' => 'training-types.index', 'icon' => 'fas fa-list mr15', 'label' => 'Training Types'],
            ['module' => 'service-types', 'route' => 'service-types.index', 'icon' => 'fas fa-th-list mr15', 'label' => 'Service Types'],
            ['module' => 'airlines', 'route' => 'airlines.index', 'icon' => 'fas fa-plane mr15', 'label' => 'Airlines'],
            ['module' => 'flight-types', 'route' => 'flight-types.index', 'icon' => 'fas fa-plane-departure mr15', 'label' => 'Flight Types'],
            ['module' => 'trips', 'route' => 'trips.index', 'icon' => 'fas fa-route mr15', 'label' => 'Trips'],
            ['module' => 'purposes', 'route' => 'purposes.index', 'icon' => 'fas fa-tags mr15', 'label' => 'Purposes'],
            ['module' => 'visa-purposes', 'route' => 'visa-purposes.index', 'icon' => 'fas fa-tags mr15', 'label' => 'Visa Purposes'],
            ['module' => 'expense-types', 'route' => 'expense-types.index', 'icon' => 'fas fa-list mr15', 'label' => 'Expense Types'],
            ['module' => 'payment-methods', 'route' => 'payment-methods.index', 'icon' => 'fas fa-credit-card mr15', 'label' => 'Payment Methods'],
            ['module' => 'countries', 'route' => 'countries.index', 'icon' => 'fas fa-flag mr15', 'label' => 'Countries'],
            ['module' => 'infos', 'route' => 'infos.index', 'icon' => 'fas fa-info-circle mr15', 'label' => 'Transaction Type'],
            ['module' => 'departments', 'route' => 'departments.index', 'icon' => 'fas fa-building mr15', 'label' => 'Departments'],
            ['module' => 'designations', 'route' => 'designations.index', 'icon' => 'fas fa-user-tag mr15', 'label' => 'Designations'],
        ],

        'Administration' => [
            ['module' => 'audit-logs', 'route' => 'audit-logs.index', 'icon' => 'fas fa-clipboard-list mr15', 'label' => 'Audit Logs'],
            ['module' => 'employees', 'route' => 'employees.index', 'icon' => 'fas fa-id-badge mr15', 'label' => 'Employees'],
            ['module' => 'users', 'route' => 'users.index', 'icon' => 'fas fa-users-cog mr15', 'label' => 'Manage User'],
        ],
    ],
];
