<?php

return [
    'Administrador' => ['dashboard', 'customers', 'products', 'categories', 'suppliers', 'orders', 'reports.sales', 'reports.inventory', 'users'],
    'Gerencia'      => ['dashboard', 'customers.view', 'products.view', 'orders.view', 'reports.sales', 'reports.inventory'],
    'Ventas'        => ['dashboard', 'customers', 'orders', 'reports.sales'],
    'Supervisor de Ventas' => ['dashboard', 'customers', 'orders', 'reports.sales'],
    'Bodega'        => ['dashboard', 'products', 'categories', 'suppliers', 'reports.inventory'],
    'Compras'       => ['dashboard', 'products', 'suppliers', 'reports.inventory'],
];