<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\user\PremiumPlan;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $referrals = User::where('referral', auth()->user()->email)->get();
        return view('user.dashboard', compact('referrals'));
    }

    public function premium(Request $request)
    {
        // save image into public folder
        $image = $request->file('paymentScreenshot');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/premium'), $imageName);
        // save image into database

        $premiumOption = new PremiumPlan();
        $premiumOption->user_id = auth()->user()->id;
        $premiumOption->email = auth()->user()->email;
        $premiumOption->premiumOption = $request->premiumOption;
        $premiumOption->paymentScreenshot = $imageName;
        $premiumOption->save();
        return redirect()->back()->with('success', 'Your request submitted successfully');
    }
}
