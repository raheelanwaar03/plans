<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\user\History;
use App\Models\user\Links;
use App\Models\user\PremiumPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $referrals = User::where('referral', auth()->user()->email)->get();
        $links = Links::get();
        return view('user.dashboard', compact('referrals', 'links'));
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

    public function link_amount($id)
    {
        $link = Links::find($id);
        // check history
        $history = History::where('user_id', auth()->user()->id)->where('type', $link->title)->whereDate('created_at', Carbon::today())->first();
        if ($history) {
            return redirect()->back()->with('error', 'You already got todays token');
        }
        $user = User::find(auth()->user()->id);
        $user->balance += $link->amount;
        $user->save();
        $history = new History();
        $history->user_id = auth()->user()->id;
        $history->type = $link->title;
        $history->amount = 2;
        $history->save();
        return redirect()->back()->with('success', 'You got this task token');
    }
}
