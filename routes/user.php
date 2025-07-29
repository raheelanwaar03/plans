<?php

use App\Http\Controllers\TradeController;
use App\Http\Controllers\user\ContactUsController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\user\UserKycController;
use App\Models\user\ContactUs;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserDashboardController::class, 'welcome'])->name('Welcom');

Route::name('User.')->prefix('User')->middleware('auth', 'user')->group(function () {
    Route::get('/Test', [UserDashboardController::class, 'test'])->name('Test');
    Route::get('/Dashboard', [UserDashboardController::class, 'index'])->name('Dashboard');
    Route::get('/Tasks', [UserDashboardController::class, 'tasks'])->name('Tasks');
    Route::get('/Booster', [UserDashboardController::class, 'booster'])->name('Booster');
    Route::get('/KYC', [UserKycController::class, 'kyc'])->name('KYC');
    Route::post('/KYC/Data', [UserKycController::class, 'index'])->name('KYC.Data');
    Route::get('/Premium', [UserDashboardController::class, 'premium_page'])->name('Premium');
    Route::post('/Premium/Option', [UserDashboardController::class, 'premium'])->name('Premium.Option');
    Route::get('/Start/Mining', [UserDashboardController::class, 'mine'])->name('Start.Mine');
    Route::get('/Link/Amount/{id}', [UserDashboardController::class, 'link_amount'])->name('Link.Amount');
    Route::post('/Boost/Tokens', [UserDashboardController::class, 'boost'])->name('Boost.Token');
    Route::post('/Send/Tokens', [UserDashboardController::class, 'sendToken'])->name('Send.Tokens');
    Route::get('/Contact', [ContactUsController::class, 'index'])->name('Contact');
    Route::get('/Transfer', [ContactUsController::class, 'transfer'])->name('Transfer');
    Route::post('/ContactUs', [ContactUsController::class, 'contactUs'])->name('Contact.Us');
    Route::get('/Trade', [TradeController::class, 'trade_token'])->name('Trade.Token');
    Route::post('/Sell/Token', [TradeController::class, 'sell_token'])->name('Sell.Token');
    Route::post('/Buy/Token', [TradeController::class, 'buy_token'])->name('Buy.Token');
});
