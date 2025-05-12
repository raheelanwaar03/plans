<?php

use App\Http\Controllers\user\ContactUsController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\user\UserKycController;
use App\Models\user\ContactUs;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserDashboardController::class, 'welcome'])->name('Welcom');

Route::name('User.')->prefix('User')->middleware('auth', 'user')->group(function () {
    Route::get('/Dashboard', [UserDashboardController::class, 'index'])->name('Dashboard');
    Route::get('/Tasks', [UserDashboardController::class, 'tasks'])->name('Tasks');
    Route::get('/Test', [UserDashboardController::class, 'test'])->name('Test');
    Route::post('/KYC/Data', [UserKycController::class, 'index'])->name('KYC.Data');
    Route::post('/ContactUs', [ContactUsController::class, 'contactUs'])->name('Contact.Us');
    Route::post('/Premium/Option', [UserDashboardController::class, 'premium'])->name('Premium.Option');
    Route::get('/Start/Mining', [UserDashboardController::class, 'mine'])->name('Start.Mine');
    Route::get('/Link/Amount/{id}', [UserDashboardController::class, 'link_amount'])->name('Link.Amount');
    Route::post('/Boost/Tokens', [UserDashboardController::class, 'boost'])->name('Boost.Token');
    Route::post('/Send/Tokens', [UserDashboardController::class, 'sendToken'])->name('Send.Tokens');
});
