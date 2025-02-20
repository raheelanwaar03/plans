<?php

use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\user\UserKycController;
use Illuminate\Support\Facades\Route;

Route::name('User.')->prefix('User')->middleware('auth')->group(function () {
    Route::get('/Dashboard', [UserDashboardController::class, 'index'])->name('Dashboard');
    Route::post('/KYC/Data', [UserKycController::class, 'index'])->name('KYC.Data');
});
