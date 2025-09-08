<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\admin\Wallet;
use App\Models\SellVipPGN;
use App\Models\TokenPrice;
use App\Models\User;
use App\Models\user\BuyVipClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BuyVIPController extends Controller
{
    public function index()
    {
        // check if user have pending request then let him wait
        $vip_check = BuyVipClass::where('user_id', auth()->user()->id)->first();
        if ($vip_check) {
            if ($vip_check->status == 'pending') {
                return redirect()->back()->with('error', 'You already request for vip class please wait.');
            }
            if ($vip_check->status == 'approved') {
                return redirect()->back()->with('error', 'You are already added in vip class, you can sell in high price now');
            }
        }
        $wallet = Wallet::first();
        return view('user.buyVIP', compact('wallet'));
    }

    public function buyVip(Request $request)
    {
        $request->validate([
            'screenShot' => 'required',
            'trxID' => 'required',
        ]);
        $screenShot = rand(1111111, 99999999) . '.' . $request->screenShot->extension();
        $request->screenShot->move(public_path('Vip/'), $screenShot);

        $buy_vip = new BuyVipClass();
        $buy_vip->user_id = auth()->user()->id;
        $buy_vip->trxID = $request->trxID;
        $buy_vip->screenShot = $screenShot;
        $buy_vip->save();
        return redirect()->route('User.Trade.Token')->with('success', 'We have recived your request successfully.You will notify soon about your membership.');
    }

    public function sellVip()
    {
        $check_status = BuyVipClass::where('user_id', auth()->user()->id)->first();
        if ($check_status->status == 'pending') {
            return redirect()->route('User.Trade.Token')->with('error', 'Please wait for admin approval');
        }

        $wallet = Wallet::first();
        $token = TokenPrice::first();
        return view('user.sellVip', compact('wallet', 'token'));
    }

    public function sellVipPGN(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if ($user->balance == 0) {
            return redirect()->back()->with('error', 'Your account balance is null');
        }

        if ($user->balance < $request->amount) {
            return redirect()->back()->with('error', 'You have not enough balance');
        }

        $transcation_check = SellVipPGN::where('user_id', auth()->user()->id)->where('status', 'pending')->whereDate('created_at', Carbon::today())->first();
        if ($transcation_check) {
            return redirect()->back()->with('error', 'You already requested for selling  PGN');
        }

        $sell_vip = new SellVipPGN();
        $sell_vip->user_id = auth()->user()->id;
        $sell_vip->pgn_amount = $request->amount;
        $sell_vip->title = $request->title;
        $sell_vip->account = $request->number;
        $sell_vip->type = $request->type;
        $sell_vip->save();
        return redirect()->back()->with('success', 'your request submitted successfully');
    }
}
