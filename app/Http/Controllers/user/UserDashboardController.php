<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\user\BoostedUser;
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
        $token_check = History::where('user_id', auth()->user()->id)->where('type', 'Mine')->whereDate('created_at', Carbon::today())->first();
        if ($token_check) {
            return redirect()->back()->with('error', 'You got todays token');
        } else {
            if ($user->status == 'booster') {
                $booster_plan = History::where('user_id', auth()->user()->id)->where('type', 'boost')->get();
                $total_amount = 0;
                foreach ($booster_plan as $boost) {
                    $total_amount += $boost->amount;
                }
                return $total_amount;
                if ($total_amount = 100) {
                    $user->balance += 10;
                    $user->save();
                    $history = new History();
                    $history->user_id = auth()->user()->id;
                    $history->type = 'Mine';
                    $history->amount = 2;
                    $history->save();
                    return redirect()->back()->with('success', 'You Mined PGN Successfully');
                }
                if ($total_amount = 300) {
                    $user->balance += 30;
                    $user->save();
                    $history = new History();
                    $history->user_id = auth()->user()->id;
                    $history->type = 'Mine';
                    $history->amount = 2;
                    $history->save();
                    return redirect()->back()->with('success', 'You Mined PGN Successfully');
                }
                if ($total_amount = 500) {
                    $user->balance += 60;
                    $user->save();
                    $history = new History();
                    $history->user_id = auth()->user()->id;
                    $history->type = 'Mine';
                    $history->amount = 2;
                    $history->save();
                    return redirect()->back()->with('success', 'You Mined PGN Successfully');
                }
            } else {
                $user->balance += 2;
                $user->save();
                $history = new History();
                $history->user_id = auth()->user()->id;
                $history->type = 'Mine';
                $history->amount = 2;
                $history->save();
                return redirect()->back()->with('success', 'You Mined PGN Successfully');
            }
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
        sleep(20);
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

    public function boost(Request $request)
    {
        $user = User::find(auth()->user()->id);
        // check if user have enough coins
        if ($user->balance < $request->tokens) {
            return redirect()->back()->with('error', 'You have not enough coins');
        }

        $boost = new BoostedUser();
        $boost->user_id = auth()->user()->id;
        $boost->user_email = auth()->user()->email;
        $boost->tokens = $request->tokens;
        $boost->save();
        $user->balance -= $request->tokens;
        $user->status = 'booster';
        $user->save();
        // make history
        $history = new History();
        $history->user_id = auth()->user()->id;
        $history->type = 'Boost';
        $history->amount = $request->tokens;
        $history->save();

        return redirect()->back()->with('success', 'You have activated booster plan');
    }

    public function sendToken(Request $request)
    {
        $validate = $request->validate([
            'email' => 'email|required',
            'token' => 'numeric',
        ]);

        $user = User::find(auth()->user()->id);
        if ($user->balance < $request->token) {
            return redirect()->back()->with('error', 'You have not enough tokens');
        }
        // find requested user
        $reciver = User::where('email', $request->email)->first();
        if (!$reciver) {
            return redirect()->back()->with('error', 'User not found');
        }

        $reciver->balance += $request->token;
        $reciver->save();
        $user->balance -= $request->token;
        $user->save();
        $history = new History();
        $history->user_id = auth()->user()->id;
        $history->type = 'sent token';
        $history->amount = $request->token;
        $history->save();
        return redirect()->back()->with('success', 'You have sent token to user');
    }
}
