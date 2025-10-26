<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\MarketingMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailMarketingcontroller extends Controller
{
    public function page()
    {
        return view('admin.emails.emailMarketing');
    }

    public function content(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        // Get verified users
        $user = User::find(2);
        // return $user->email;
        Mail::to($user->email)->queue(new MarketingMail($request->subject, $request->message));
        return back()->with('success', 'Email has been sent to all verified users!');
    }
}
