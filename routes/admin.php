<?php

use App\Http\Controllers\admin\AdminDashboradController;
use Illuminate\Support\Facades\Route;

Route::name('Admin.')->prefix('Admin')->middleware('auth', 'admin')->group(function () {
    Route::get('/Dashboard', [AdminDashboradController::class, 'index'])->name('Dashboard');
    Route::get('/KYC/Requests', [AdminDashboradController::class, 'kyc'])->name('KYC.Requests');
    Route::get('/ContactUs/Request', [AdminDashboradController::class, 'contactRequest'])->name('ContactUs.Request');
});
