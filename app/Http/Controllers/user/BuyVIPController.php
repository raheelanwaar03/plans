<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\admin\Wallet;
use App\Models\TokenPrice;
use App\Models\user\BuyVipClass;
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
        $wallet = Wallet::first();
        $token = TokenPrice::first();
        return view('user.sellVip', compact('wallet','token'));
    }
}
