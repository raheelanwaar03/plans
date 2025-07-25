<?php

namespace App\Http\Controllers;

use App\Models\buyingTokens;
use App\Models\SellingTokens;
use App\Models\TokenPrice;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function settings()
    {
        $tokenPrice = TokenPrice::first();
        return view('admin.setting.index', compact('tokenPrice'));
    }

    public function token_price(Request $request)
    {
        // Validate the request data
        $request->validate([
            'price' => 'numeric|min:0',
            'selling_price' => 'numeric|min:0',
            'buying_price' => 'numeric|min:0',
        ]);
        // Find the first token price record
        $token = TokenPrice::first();
        if (!$token) {
            // If no token price exists, create a new one
            $token = new TokenPrice();
            $token->price = $request->input('price');
            $token->selling_price = $request->input('selling_price');
            $token->buying_price = $request->input('buying_price');
        }
        // Update the token price details
        $token->price = $request->input('price');
        $token->selling_price = $request->input('selling_price');
        $token->buying_price = $request->input('buying_price');
        $token->save();
        return redirect()->route('Admin.Settings')->with('success', 'Token price updated successfully.');
    }

    public function sell_token()
    {
        $tokenPrice = TokenPrice::first();
        $selling_requests = SellingTokens::get();
        return view('admin.setting.sell_token', compact('selling_requests','tokenPrice'));
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
}
