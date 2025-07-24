<?php

namespace App\Http\Controllers;

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
}
