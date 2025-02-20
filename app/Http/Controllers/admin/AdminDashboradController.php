<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\user\UserKycController;
use App\Models\User;
use App\Models\user\KYC;
use Illuminate\Http\Request;

class AdminDashboradController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('admin.dashboard', compact('users'));
    }

    public function kyc()
    {
        $kyc = KYC::get();
        return view('admin.kyc.requests', compact('kyc'));
    }
}
