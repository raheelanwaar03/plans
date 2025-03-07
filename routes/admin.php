<?php

use App\Http\Controllers\admin\AdminDashboradController;
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
});
