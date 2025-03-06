<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\Auth\AuthLoginController::class, 'send']);
    Route::post('register', [\App\Http\Controllers\Auth\AuthRegisterController::class, 'send']);

    Route::middleware('auth:sanctum')->post('logout', [\App\Http\Controllers\Auth\AuthLoginController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('user', [\App\Http\Controllers\Auth\AuthLoginController::class, 'get']);
});

Route::middleware('auth:sanctum')->prefix('dashboard')->group(function () {
    Route::controller(\App\Http\Controllers\Dashboard\DashboardHomeController::class)->prefix('home')->group(function () {
        Route::get('get', 'get');
    });

    Route::controller(\App\Http\Controllers\Dashboard\DashboardClientController::class)->prefix('clients')->group(function () {
        Route::get('get', 'get');
        Route::get('view/{id}', 'view');
        Route::post('create', 'create');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'delete');
    });

    Route::controller(\App\Http\Controllers\Dashboard\DashboardSupplierController::class)->prefix('suppliers')->group(function () {
        Route::get('get', 'get');
        Route::get('view/{id}', 'view');
        Route::post('create', 'create');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'delete');
    });

    Route::controller(\App\Http\Controllers\Dashboard\DashboardProductController::class)->prefix('products')->group(function () {
        Route::get('get', 'get');
        Route::get('getFormData', 'getFormData');
        Route::get('view/{id}', 'view');
        Route::post('create', 'create');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'delete');
    });

    Route::controller(\App\Http\Controllers\Dashboard\DashboardSellController::class)->prefix('sells')->group(function () {
        Route::get('get', 'get');
        Route::get('getFormData', 'getFormData');
        Route::get('view/{id}', 'view');
        Route::post('create', 'create');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'delete');
    });

    Route::controller(\App\Http\Controllers\Dashboard\DashboardStockController::class)->prefix('stock')->group(function () {
        Route::get('get', 'get');
        Route::get('getFormData', 'getFormData');
        Route::get('view/{id}', 'view');
        Route::post('create', 'create');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'delete');
    });
});
