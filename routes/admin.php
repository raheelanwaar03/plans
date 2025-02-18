<?php

use Illuminate\Support\Facades\Route;

Route::name('Admin.')->prefix('Admin')->middleware('auth')->group(function () {
    // Route::get('/Dashboard', [AdminDashboardController::class, 'index'])->name('Dashboard');
});
