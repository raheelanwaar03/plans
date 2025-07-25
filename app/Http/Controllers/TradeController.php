<?php

namespace App\Http\Controllers;

use App\Models\SellingTokens;
use App\Models\TokenPrice;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    /**
     * Display the trade token page.
     *
     * @return \Illuminate\View\View
     */
    public function trade_token()
    {
        $tokenPrice = TokenPrice::first();
        return view('user.trade', compact('tokenPrice'));
    }

    public function sell_token(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phoneNO' => 'required|digits:11',
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'screenShot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // change the file name to a unique name
        $fileName = time() . '.' . $request->screenShot->extension();
        $request->screenShot->move(public_path('sellToken'), $fileName);

        $selling_token = new SellingTokens();
        $selling_token->user_id = auth()->user()->id;
        $selling_token->email = $request->email;
        $selling_token->phoneNO = $request->phoneNO;
        $selling_token->title = $request->title;
        $selling_token->amount = $request->amount;
        $selling_token->screenShot = $fileName;
        $selling_token->status = 'pending';
        $selling_token->save();

        return redirect()->back()->with('success', 'Your request of selling token has been received successfully!');
    }

    public function buy_token(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'screenShot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // change the file name to a unique name
        $fileName = time() . '.' . $request->screenShot->extension();
        $request->screenShot->move(public_path('buyToken'), $fileName);

        // save in database
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';
        $data['screenShot'] = $fileName;

        return redirect()->back()->with('success', 'Token bought successfully!');
    }
}
