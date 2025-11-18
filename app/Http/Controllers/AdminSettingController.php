<?php

namespace App\Http\Controllers;

use App\Models\admin\Wallet;
use App\Models\buyingTokens;
use App\Models\SellingTokens;
use App\Models\TokenPrice;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function settings()
    {
        $token = TokenPrice::first();
        return view('admin.setting.index', compact('token'));
    }

    public function token_updation(Request $request, $id)
    {
        $token = TokenPrice::find($id);
        $token->price = $request->price;
        $token->selling_price = $request->selling_price;
        $token->buying_price = $request->buying_price;
        $token->vip_price = $request->vip_price;
        $token->save();
        return redirect()->back()->with('success', 'Token Prices updated');
    }

    public function sell_token()
    {
        $tokenPrice = TokenPrice::first();
        $selling_requests = SellingTokens::get();
        return view('admin.setting.sell_token', compact('selling_requests', 'tokenPrice'));
    }

    public function buy_token()
    {
        // get latests price of token
        $tokenPrice = TokenPrice::first();
        $buying_requests = buyingTokens::get();
        return view('admin.setting.buy_token', compact('buying_requests', 'tokenPrice'));
    }

    // change Status of Buying Request
    public function buy_token_approve($id)
    {
        $buying_request = buyingTokens::find($id);
        if ($buying_request) {
            $buying_request->status = 'approved';
            $buying_request->save();
            // Update user's balance if needed
            // $user = User::find($buying_request->user_id);
            // $user->balance += $buying_request->amount;
            // $user->save();
            return redirect()->back()->with('success', 'Buying request approved successfully.');
        }
        return redirect()->back()->with('error', 'Buying request not found.');
    }

    public function buy_token_reject($id)
    {
        $buying_request = buyingTokens::find($id);
        if ($buying_request) {
            $buying_request->status = 'rejected';
            $buying_request->save();
            return redirect()->back()->with('success', 'Buying request rejected successfully.');
        }
        return redirect()->back()->with('error', 'Buying request not found.');
    }
    // selling requests

    public function sell_token_reject($id)
    {
        $selling_request = SellingTokens::find($id);
        if ($selling_request) {
            $selling_request->status = 'rejected';
            $selling_request->save();
            return redirect()->back()->with('success', 'Selling request rejected successfully.');
        }
        return redirect()->back()->with('error', 'Selling request not found.');
    }

    public function sell_token_approve($id)
    {
        $selling_request = SellingTokens::find($id);
        if ($selling_request->status == 'approved') {
            return redirect()->back()->with('error', 'Already Approved');
        }
        if ($selling_request) {
            $selling_request->status = 'approved';
            $selling_request->save();
            // Update user's balance if needed
            $user = User::find($selling_request->user_id);
            $user->balance -= $selling_request->amount;
            $user->save();
            return redirect()->back()->with('success', 'Selling request approved successfully.');
        }
        return redirect()->back()->with('error', 'Selling request not found.');
    }

    public function update_wallet()
    {
        $walletDetails = Wallet::first();
        return view('admin.setting.wallet', compact('walletDetails'));
    }

    public function update_wallet_details(Request $request, $id)
    {
        $walletDetails = Wallet::find($id);
        if (!$walletDetails) {
            return redirect()->back()->with('error', 'Wallet details not found.');
        }

        // Update the wallet details
        $walletDetails->email = $request->input('email');
        $walletDetails->number = $request->input('number');
        $walletDetails->name = $request->input('name');
        $walletDetails->wallet = $request->input('wallet');
        $walletDetails->save();

        return redirect()->route('Admin.Update.Wallet.Details')->with('success', 'Wallet details updated successfully.');
    }

    public function sendToken(Request $request)
    {
        $mail_user = User::where('email', $request->email)->first();

        if (!$mail_user) {
            return redirect()->back()->with('error', 'No user found with this mail');
        }
        $mail_user->balance += $request->token_amount;
        $mail_user->save();
        return redirect()->back()->with('success', 'Token Added To User Account Successfully');
    }

    // Wallet updation

    public function premium_wallet(Request $request, $id)
    {
        $premium_wallet = Wallet::find($id);
        $premium_wallet->premium_name =  $request->premium_name;
        $premium_wallet->premium_wallet =  $request->premium_wallet;
        $premium_wallet->premium_number =  $request->premium_number;
        $premium_wallet->save();
        return redirect()->back()->with('success', 'Premium wallet details update');
    }

    public function kyc_wallet(Request $request, $id)
    {
        $kyc_wallet = Wallet::find($id);
        $kyc_wallet->kyc_name =  $request->kyc_name;
        $kyc_wallet->kyc_wallet =  $request->kyc_wallet;
        $kyc_wallet->kyc_number =  $request->kyc_number;
        $kyc_wallet->save();
        return redirect()->back()->with('success', 'Premium wallet details update');
    }

    public function lucky_wallet(Request $request, $id)
    {
        $lucky_wallet = Wallet::find($id);
        $lucky_wallet->lucky_name =  $request->lucky_name;
        $lucky_wallet->lucky_wallet =  $request->lucky_wallet;
        $lucky_wallet->lucky_number =  $request->lucky_number;
        $lucky_wallet->save();
        return redirect()->back()->with('success', 'Premium wallet details update');
    }

    public function vip_wallet(Request $request, $id)
    {
        $vip_wallet = Wallet::find($id);
        $vip_wallet->vip_name =  $request->vip_name;
        $vip_wallet->vip_wallet =  $request->vip_wallet;
        $vip_wallet->vip_number =  $request->vip_number;
        $vip_wallet->save();
        return redirect()->back()->with('success', 'Premium wallet details update');
    }

    public function binance_wallet(Request $request, $id)
    {
        $vip_wallet = Wallet::find($id);
        $vip_wallet->binance_wallet =  $request->binance_wallet;
        $vip_wallet->binance_address =  $request->binance_address;
        $vip_wallet->save();
        return redirect()->back()->with('success', 'Binance wallet details update');
    }
}
