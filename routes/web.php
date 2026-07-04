<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return 'Admin Area';
        })->name('admin.index');
    });

    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/inventory', function () {
            return redirect()->route('products.index');
        })->name('inventory.index');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class);

        Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])
        ->name('borrowings.return');

        Route::resource('borrowings', BorrowingController::class)
        ->only(['index', 'create', 'store', 'show']);
    });

    Route::middleware('role:admin,manager')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    });
});

require __DIR__.'/auth.php';
