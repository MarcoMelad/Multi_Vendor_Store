<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard'
    ],
    [
        'icon' => 'fa fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'new',
        'active' => 'categories.*'
    ],
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'categories.index',
        'title' => 'Products',
        'active' => 'products.*'
    ],
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active' => 'orders.*'
    ],
];
