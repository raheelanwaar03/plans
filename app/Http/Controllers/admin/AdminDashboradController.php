<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\user\UserKycController;
use App\Models\User;
use App\Models\user\ContactUs;
use App\Models\user\KYC;
use App\Models\user\PremiumPlan;
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

    public function contactRequest()
    {
        $request = ContactUs::get();
        return view('admin.contact.request', compact('request'));
    }

    public function pendingPremium()
    {
        $premium = PremiumPlan::get();
        return view('admin.premium.pending', compact('premium'));
    }

    public function approveKYC($id)
    {
        $kyc = KYC::find($id);
        $kyc->status = 'approved';
        $kyc->save();
        return redirect()->back()->with('success', 'KYC approved successfully');
    }

    public function rejectKYC($id)
    {
        $kyc = KYC::find($id);
        $kyc->status = 'rejected';
        $kyc->save();
        return redirect()->back()->with('success', 'KYC rejected successfully');
    }

    public function approvePremium($id)
    {
        $premium = PremiumPlan::find($id);
        $premium->status = 'approved';
        $premium->save();
        return redirect()->back()->with('success', 'Premium Plan Approved');
    }

    public function rejectPremium($id)
    {
        $premium = PremiumPlan::find($id);
        $premium->status = 'rejected';
        $premium->save();
        return redirect()->back()->with('success', 'Premium Plan Rejected');
    }

    public function addToken($id)
    {
        $premium = PremiumPlan::find($id);
        return view('admin.premium.addToken', compact('premium'));
    }

    public function storeToken(Request $request ,$id)
    {
        $user = User::find($request->user_id);
        $user->balance += $request->amount;
        $user->save();
        return redirect()->back()->with('success', 'Token added successfully');
    }

}
