<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::middleware(['guest:admin-api'])->group(function () {
            Route::post('login', LoginController::class);
        });
        Route::middleware(['auth:admin-api'])->group(function () {
            Route::post('logout', LogoutController::class);
        });
    });

    Route::middleware(['auth:admin-api'])->group(function () {

        Route::prefix('users')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::get('trashed', 'trashed');
                Route::get('{user}', 'show');
                Route::delete('{user}', 'destroy');
                Route::post('{trashedUser}/restore', 'restore');
                Route::delete('{trashedUser}/permanent', 'permanent');
            });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);

            Route::prefix('categories')
                ->controller(ProductCategoryController::class)
                ->group(function () {
                    Route::get('/', 'index');
                });

            Route::prefix('brands')
                ->controller(ProductBrandController::class)
                ->group(function () {
                    Route::get('/', 'index');
                });

            Route::prefix('brands')
                ->controller(ProductTypeController::class)
                ->group(function () {
                    Route::get('/', 'index');
                });
        });

        Route::prefix('transactions')
            ->controller(TransactionController::class)
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::prefix('invoices')
            ->controller(InvoiceController::class)
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::prefix('deposits')
            ->controller(DepositController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::get('{user}', 'show');
                Route::put('{user}', 'update');
            });

    });
});
