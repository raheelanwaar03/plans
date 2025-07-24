<?php

namespace App\Http\Controllers;

use App\Models\TokenPrice;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function settings()
    {
        $tokenPrice = TokenPrice::first();
        $token_price = $tokenPrice->price;
        return view('admin.setting.index', compact('token_price'));
    }

    public function token_price(Request $request)
    {
        // Validate the request data
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);
        // Update the token price
        $tokenPrice = TokenPrice::first();
        if (!$tokenPrice) {
            $tokenPrice = new TokenPrice();
        }
        $tokenPrice->price = $request->input('price');
        $tokenPrice->save();

        return redirect()->route('Admin.Settings')->with('success', 'Token price updated successfully.');
    }
}
