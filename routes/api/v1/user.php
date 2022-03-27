<?php

use App\Http\Controllers\User\Auth\EmailVerificationController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogoutController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\ProductCategoryController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\Xendit\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::middleware(['guest:user-api'])->group(function () {
        Route::post('register', RegisterController::class);
        Route::post('login', LoginController::class);
        Route::post('verify-email', EmailVerificationController::class);
        Route::post('forgot-password', ForgotPasswordController::class);
    });
    Route::middleware(['auth:user-api'])->group(function () {
        Route::post('logout', LogoutController::class);
    });
});

Route::prefix('categories')
    ->middleware(['auth:user-api'])
    ->controller(ProductCategoryController::class)
    ->group(function () {
        Route::get('/', 'index');
    });

Route::prefix('products')
    ->middleware(['auth:user-api'])
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('{productCategory}', 'index');
        Route::post('{product}/purchase', 'purchase');
    });

Route::prefix('transactions')
    ->controller(TransactionController::class)
    ->group(function () {

        Route::middleware(['auth:user-api'])->group(function () {
            Route::get('/', 'index');
            Route::get('{authenticatedTransaction}', 'show');
            Route::post('purchase', 'purchase');
        });

        Route::middleware(['verifyDigiflazzCallback'])->group(function () {
            Route::post('callback', 'callback'); // still dev
        });
    });

Route::prefix('invoices')
    ->controller(InvoiceController::class)
    ->group(function () {

        Route::middleware(['auth:user-api'])->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('{authenticatedInvoice}', 'show');
        });

        Route::middleware(['verifyXenditCallback'])->group(function () {
            Route::post('callback', 'callback');
        });
    });
