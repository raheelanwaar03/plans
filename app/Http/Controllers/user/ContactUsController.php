<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function index()
    {
        return view('user.contact');
    }

    public function transfer()
    {
        return view('user.transfer');
    }

    public function contactUs(Request $request)
    {
        //check if request have file
        $pic = time() . '.' . $request->pic->extension();
        $request->pic->move(public_path('images/ContactUs'), $pic);
        // save into database
        $contactUs = new ContactUs();
        $contactUs->user_id = auth()->user()->id;
        $contactUs->name = $request->name;
        $contactUs->email = $request->email;
        $contactUs->country = $request->country;
        $contactUs->pic = $pic;
        $contactUs->massage = $request->message;
        $contactUs->save();
        return redirect()->back()->with('success', 'Your message has been submitted');
    }
}
