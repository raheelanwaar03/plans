<?php

use App\Http\Controllers\admin\AdminDashboradController;
use App\Http\Controllers\admin\AdminLuckyDrawController;
use App\Http\Controllers\admin\EmailMarketingcontroller;
use App\Http\Controllers\AdminSettingController;
use Illuminate\Support\Facades\Route;

Route::name('Admin.')->prefix('Admin')->middleware('auth', 'admin')->group(function () {
    Route::get('/Dashboard', [AdminDashboradController::class, 'index'])->name('Dashboard');
    Route::get('/Delete/User/{id}', [AdminDashboradController::class, 'deleteUser'])->name('Delete.User');
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
    Route::get('/Make/Buying/Request/Approve/{id}', [AdminSettingController::class, 'buy_token_approve'])->name('Approve.Buy.Token.Request');
    Route::get('/Make/Buying/Request/Reject/{id}', [AdminSettingController::class, 'buy_token_reject'])->name('Reject.Buy.Token.Request');
    Route::get('/Make/Selling/Request/Approve/{id}', [AdminSettingController::class, 'sell_token_approve'])->name('Approve.sell.Token.Request');
    Route::get('/Make/Selling/Request/Reject/{id}', [AdminSettingController::class, 'sell_token_reject'])->name('Reject.sell.Token.Request');
    Route::get('/Update/Wallet/Details', [AdminSettingController::class, 'update_wallet'])->name('Update.Wallet.Details');
    Route::post('/Update/Wallet/Details/{id}', [AdminSettingController::class, 'update_wallet_details'])->name('Update.Wallet');
    // Add luckyDraw
    Route::get('/Add/Lucky/Item', [AdminLuckyDrawController::class, 'add'])->name('Add.Lucky.Item');
    Route::post('/Store/Lucky/Item', [AdminLuckyDrawController::class, 'store'])->name('Store.Lucky.Item');
    Route::get('/All/Lucky/Items', [AdminLuckyDrawController::class, 'all'])->name('All.Lucky.Items');
    Route::get('/Deposit/Requests', [AdminLuckyDrawController::class, 'requests'])->name('Deposit.Requests');
    Route::get('/Approve/Deposit/Request/{id}', [AdminLuckyDrawController::class, 'approveReq'])->name('Approve.Deposit.Request');
    Route::get('/All/Participante', [AdminLuckyDrawController::class, 'participante'])->name('All.Participantes');
    Route::get('/Chosse/Winner/{id}', [AdminLuckyDrawController::class, 'winner'])->name('Chosse.Winner');
    Route::get('/Del/Item/{id}', [AdminLuckyDrawController::class, 'delItem'])->name('Del.Item');
    Route::get('/Del/Participant/{id}', [AdminLuckyDrawController::class, 'delParticipant'])->name('Del.Participant');
    // Tasks
    Route::get('All/Tasks', [AdminDashboradController::class, 'allTasks'])->name('All.Tasks');
    Route::get('Delete/Task/{id}', [AdminDashboradController::class, 'deleteTask'])->name('Delete.Task');
    Route::get('Add/Task', [AdminDashboradController::class, 'addTask'])->name('Add.Task');
    Route::post('Store/Task', [AdminDashboradController::class, 'storeTask'])->name('Store.Task');
    // vip membership
    Route::get('Vip/Memberships', [AdminDashboradController::class, 'vipMembership'])->name('Vip.Membership');
    Route::get('Approve/Membership/{id}', [AdminDashboradController::class, 'approveMembership'])->name('Approve.Membership');
    Route::get('Rejected/Membership/{id}', [AdminDashboradController::class, 'rejectMembership'])->name('Reject.Membership');
    Route::get('Vip/Sell/Token', [AdminDashboradController::class, 'vipSell'])->name('Vip.Sell.Tokens');
    Route::get('Vip/Sell/Token/Approve/{id}', [AdminDashboradController::class, 'vipSellApprove'])->name('Vip.Sell.Token.Approve');
    Route::get('Del/Transcation/{id}', [AdminDashboradController::class, 'delTranscation'])->name('Delete.Transcation');
    // send token to user mail
    Route::post('Send/Token/To/User/Mail', [AdminSettingController::class, 'sendToken'])->name('Send.Token.To.User.Mail');
    // Send mail
    Route::get('Email.Marketing.Page', [EmailMarketingcontroller::class, 'page'])->name('Email.Marketing.Page');
    Route::post('Email.Content', [EmailMarketingcontroller::class, 'content'])->name('Email.Marketing.Content');
    // password update
    Route::post('Update.Password/{id}', [AdminDashboradController::class, 'updatePassword'])->name('Update.Password');
});
