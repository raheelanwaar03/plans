<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\user\History;
use App\Models\user\PremiumPlan;
use Carbon\Carbon;
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

    public function mine()
    {
        $user = User::find(auth()->user()->id);
        // check if user got today's token
        $token_check = History::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->first();
        if ($token_check) {
            return redirect()->back()->with('error', 'You got todays token');
        } else {
            $user->balance += 2;
            $user->save();
            $history = new History();
            $history->user_id = auth()->user()->id;
            $history->type = 'Mine';
            $history->amount = 2;
            $history->save();
            return redirect()->back()->with('success', 'You got todays PGN');
        }
    }
}
