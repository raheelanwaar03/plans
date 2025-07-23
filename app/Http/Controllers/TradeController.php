<?php

namespace App\Http\Controllers;

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
        return view('user.trade');
    }
}
