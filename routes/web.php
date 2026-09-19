<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StatusController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UnitMeasurementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductSupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HeaderOrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ══ AUTH (sin login requerido) ══
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══ TODO LO DE ABAJO REQUIERE SESIÓN INICIADA ══
Route::middleware('auth')->group(function () {

    // Redirige "/" al dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifications/poll', [NotificationController::class, 'poll'])->name('notifications.poll');

    // ── Clientes ──
    Route::middleware('can.access:customers')->group(function () {
        Route::resource('customers', CustomerController::class);
    });

    // ── Productos ──
    Route::middleware('can.access:products')->group(function () {
        Route::resource('products', ProductController::class);

        // Tablas de apoyo que se usan dentro del formulario de Productos.
        // Se gatean con el mismo permiso 'products' porque no existe
        // (todavía) un módulo propio para ellas en permissions.php.
        // Si algún rol necesita gestionarlas por separado, agrégales
        // su propia clave (ej. 'subcategories') en config/permissions.php
        // y cambia el middleware de este bloque a esa clave.
        Route::resource('subcategories', SubCategoryController::class);
        Route::resource('units', UnitMeasurementController::class);
        Route::resource('product-suppliers', ProductSupplierController::class);
    });

    // ── Categorías ──
    Route::middleware('can.access:categories')->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    // ── Proveedores ──
    Route::middleware('can.access:suppliers')->group(function () {
        Route::resource('suppliers', SupplierController::class);
    });

    // ── Órdenes ──
    Route::middleware('can.access:orders')->group(function () {
        Route::resource('orders', HeaderOrderController::class);
        Route::resource('order-details', OrderDetailController::class);
        Route::get('/orders/{order}/invoice', [HeaderOrderController::class, 'invoice'])->name('orders.invoice');
    });

    // ── Reportes ──
    Route::middleware('can.access:reports.sales')->group(function () {
        Route::get('/reports/sales', [ReportController::class, 'salesForm'])->name('reports.sales.form');
        Route::get('/reports/sales/pdf', [ReportController::class, 'salesReport'])->name('reports.sales.pdf');
    });

    Route::middleware('can.access:reports.inventory')->group(function () {
        Route::get('/reports/inventory', [ReportController::class, 'inventoryForm'])->name('reports.inventory.form');
        Route::get('/reports/inventory/pdf', [ReportController::class, 'inventoryReport'])->name('reports.inventory.pdf');
    });

    // ══ SOLO ADMINISTRADOR ══
    // Usuarios, Roles y Status son tablas de configuración del sistema:
    // se gatean con 'users', que en permissions.php solo tiene el rol Administrador.
    Route::middleware('can.access:users')->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('status', StatusController::class);
    });
});
