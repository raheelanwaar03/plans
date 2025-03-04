<?php

use App\Http\Controllers\user\ContactUsController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\user\UserKycController;
use App\Models\user\ContactUs;
use Illuminate\Support\Facades\Route;

Route::name('User.')->prefix('User')->middleware('auth', 'user')->group(function () {
    Route::get('/Dashboard', [UserDashboardController::class, 'index'])->name('Dashboard');
    Route::post('/KYC/Data', [UserKycController::class, 'index'])->name('KYC.Data');
    Route::post('/ContactUs', [ContactUsController::class, 'contactUs'])->name('Contact.Us');
    Route::post('/Premium/Option', [UserDashboardController::class, 'premium'])->name('Premium.Option');
});
