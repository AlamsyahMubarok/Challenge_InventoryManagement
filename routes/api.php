<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BorrowingApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReportApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::middleware('role:admin,staff')
        ->name('api.')
        ->group(function () {
            Route::apiResource('categories', CategoryApiController::class);
            Route::apiResource('products', ProductApiController::class);

            Route::get('/borrowings', [BorrowingApiController::class, 'index'])
                ->name('borrowings.index');

            Route::post('/borrowings', [BorrowingApiController::class, 'store'])
                ->name('borrowings.store');

            Route::get('/borrowings/{borrowing}', [BorrowingApiController::class, 'show'])
                ->name('borrowings.show');

            Route::patch('/borrowings/{borrowing}/return', [BorrowingApiController::class, 'returnItem'])
                ->name('borrowings.return');
        });

    Route::middleware('role:admin,manager')
        ->name('api.')
        ->group(function () {
            Route::get('/reports', [ReportApiController::class, 'index'])
                ->name('reports.index');
        });
});
