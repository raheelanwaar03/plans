<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $referrals = User::where('referral', auth()->user()->email)->get();
        return view('user.dashboard', compact('referrals'));
    }
}
