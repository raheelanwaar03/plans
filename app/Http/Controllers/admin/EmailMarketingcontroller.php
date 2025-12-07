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
            'message' => 'required|string',
        ]);

        $users = User::pluck('email')->toArray();

        foreach ($users as $email) {
            Mail::to($email)->queue(new MarketingMail($request->message));
        }

        return back()->with('success', 'Emails sent successfully!');
    }
}
