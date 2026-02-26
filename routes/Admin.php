<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SystemSettingController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function () {
        // User Management
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Product Management
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Brand Management
        Route::prefix('brand')->name('brand.')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
            Route::get('/create', [BrandController::class, 'create'])->name('create');
            Route::post('/', [BrandController::class, 'store'])->name('store');
            Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('edit');
            Route::put('/{brand}', [BrandController::class, 'update'])->name('update');
            Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('destroy');
        });

        // Category Management
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        // Customer Management
        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/ledger', [CustomerController::class, 'ledger'])->name('ledger');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/', [CustomerController::class, 'store'])->name('store');
            Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::post('/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Role Management
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('/{role}/permissions', [RoleController::class, 'permissions'])->name('permissions');
            Route::put('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('permissions.update');
        });

        // System Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SystemSettingController::class, 'edit'])->name('edit');
            Route::post('/', [SystemSettingController::class, 'update'])->name('update');
        });
    });
});
