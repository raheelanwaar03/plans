<?php

use App\Http\Controllers\admin\AdminDashboradController;
use App\Http\Controllers\AdminSettingController;
use Illuminate\Support\Facades\Route;

Route::name('Admin.')->prefix('Admin')->middleware('auth', 'admin')->group(function () {
    Route::get('/Dashboard', [AdminDashboradController::class, 'index'])->name('Dashboard');
    Route::get('/KYC/Requests', [AdminDashboradController::class, 'kyc'])->name('KYC.Requests');
    Route::get('/KYC/Approve/{id}', [AdminDashboradController::class, 'approveKYC'])->name('Approve.KYC');
    Route::get('/KYC/Rejected/{id}', [AdminDashboradController::class, 'rejectKYC'])->name('Rejected.KYC');
    Route::get('/ContactUs/Request', [AdminDashboradController::class, 'contactRequest'])->name('ContactUs.Request');
    Route::get('/Premium/Requests', [AdminDashboradController::class, 'pendingPremium'])->name('Premium.Requests');
    Route::get('/Premium/Approve/{id}', [AdminDashboradController::class, 'approvePremium'])->name('Approve.Premium');
    Route::get('/Premium/Rejected/{id}', [AdminDashboradController::class, 'rejectPremium'])->name('Rejected.Premium');
    Route::get('/Premium/Add/Token/{id}', [AdminDashboradController::class, 'addToken'])->name('Add.Token');
    Route::post('/Store/Premium/Token/{id}', [AdminDashboradController::class, 'storeToken'])->name('Store.Token');
    Route::get('/Setting', [AdminSettingController::class, 'settings'])->name('Settings');
    Route::post('/Setting/Token/Price', [AdminSettingController::class, 'token_price'])->name('Token.Price');
    Route::get('/Trading/Tokens/Sell', [AdminSettingController::class, 'sell_token'])->name('Sell.Token.Requests');
    Route::get('/Trading/Tokens/Buying', [AdminSettingController::class, 'buy_token'])->name('Buy.Token.Requests');
});
