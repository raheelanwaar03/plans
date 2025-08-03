<?php

namespace App\Http\Controllers;

use App\Models\admin\Wallet;
use App\Models\buyingTokens;
use App\Models\SellingTokens;
use App\Models\TokenPrice;
use App\Models\User;
use App\Models\user\History;
use App\Models\user\KYC;
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
        // check user kyc
        $user = KYC::where('user_id', auth()->user()->id)->first();
        if (!$user || $user->status !== 'approved') {
            return redirect()->route('User.KYC')->with('error', 'You must complete KYC to trade tokens.');
        }

        $tokenPrice = TokenPrice::first();
        $wallet = Wallet::first();
        return view('user.trade', compact('tokenPrice', 'wallet'));
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
        // check if user have enough tokens
        if (auth()->user()->balance < $request->amount) {
            return redirect()->back()->with('error', 'You do not have enough tokens to sell.');
        }
        if ($request->amount < 100) {
            return redirect()->back()->with('error', 'You must have 100 tokens to sell.');
        }

        // check if user already has a pending selling request
        $pendingRequest = SellingTokens::where('user_id', auth()->user()->id)
            ->where('status', 'pending')
            ->first();
        if ($pendingRequest) {
            return redirect()->back()->with('error', 'You already have a pending selling request.');
        }
        // check if user have sold 100 tokens in the last 24 hours
        $last24Hours = now()->subDay();
        $soldTokensCount = SellingTokens::where('user_id', auth()->user()->id)
            ->where('status', 'approved')
            ->where('created_at', '>=', $last24Hours)
            ->count();
        if ($soldTokensCount >= 100) {
            return redirect()->back()->with('error', 'You can only sell 100 tokens in the last 24 hours.');
        }

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

        // deduct the tokens from user balance
        $user = User::find(auth()->user()->id);
        $user->balance -= $request->amount;
        $user->save();
        // saving into the history
        $history = new History();
        $history->user_id = auth()->user()->id;
        $history->type = 'selling';
        $history->amount = $request->amount;
        $history->save();

        return redirect()->back()->with('success', 'Your request of selling ' . $request->amount . ' token has been received successfully on ' . $request->email . '');
    }

    public function buy_token(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'paySS' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // change the file name to a unique name
        $fileName = time() . '.' . $request->paySS->extension();
        $request->paySS->move(public_path('buyToken'), $fileName);
        // Save the request data to the database
        $buying_tokens = new buyingTokens();
        $buying_tokens->user_id = auth()->user()->id;
        $buying_tokens->email = $request->email;
        $buying_tokens->amount = $request->amount;
        $buying_tokens->paySS = $fileName;
        $buying_tokens->status = 'pending';
        $buying_tokens->save();

        return redirect()->back()->with('success', 'Buying token request has been received successfully!');
    }
}
