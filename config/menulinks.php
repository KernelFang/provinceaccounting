<?php

return [
    'sections' => [
        'Organize and Manage' => [
            ['module' => 'projects', 'route' => 'projects.index', 'icon' => 'fas fa-project-diagram mr15', 'label' => 'Projects'],
            ['module' => 'clients', 'route' => 'clients.index', 'icon' => 'fas fa-user-tie mr15', 'label' => 'Clients'],
            ['module' => 'flats', 'route' => 'flats.index', 'icon' => 'fas fa-building mr15', 'label' => 'Flats'],
            ['module' => 'flat-pricing-histories', 'route' => 'flat-pricing-histories.index', 'icon' => 'fas fa-history mr15', 'label' => 'Flat Pricing'],
            ['module' => 'petty-cashes', 'route' => 'petty-cashes.index', 'icon' => 'fas fa-wallet mr15', 'label' => 'Petty Cash'],
            ['module' => 'incomes', 'route' => 'incomes.index', 'icon' => 'fas fa-hand-holding-dollar mr15', 'label' => 'Incomes'],
            ['module' => 'expenses', 'route' => 'expenses.index', 'icon' => 'fas fa-money-check-alt mr15', 'label' => 'Expenses'],
        ],

        'Reports' => [
            ['module' => 'reports', 'route' => 'reports.index', 'icon' => 'fas fa-chart-bar mr15', 'label' => 'Reports'],
        ],

        'Settings' => [
            ['module' => 'expense-types', 'route' => 'expense-types.index', 'icon' => 'fas fa-list mr15', 'label' => 'Expense Types'],
            ['module' => 'payment-methods', 'route' => 'payment-methods.index', 'icon' => 'fas fa-credit-card mr15', 'label' => 'Payment Methods'],
            ['module' => 'countries', 'route' => 'countries.index', 'icon' => 'fas fa-flag mr15', 'label' => 'Countries'],
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
