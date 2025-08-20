<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\admin\LuckyDrawItems;
use App\Models\User;
use App\Models\user\LuckyParticipant;
use App\Models\user\UserDeposit;
use Illuminate\Http\Request;

class LuckyDrawController extends Controller
{
    public function index()
    {
        $luck = LuckyDrawItems::get();
        return view('user.luckydraw.index',compact('luck'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'trxID' => 'required',
            'screenShot' => 'required',
        ]);
        // front ID image save
        $screenShot = rand(1111111, 99999999) . '.' . $request->screenShot->extension();
        $request->screenShot->move(public_path('images/screenShot'), $screenShot);

        $deposit = new UserDeposit();
        $deposit->user_id = auth()->user()->id;
        $deposit->amount = $request->amount;
        $deposit->trxID = $request->trxID;
        $deposit->screenShot = $screenShot;
        $deposit->save();
        return redirect()->back()->with('success', 'your request submitted successfully');
    }

    public function participate($id)
    {
        $participant = new LuckyParticipant();
        $participant->user_id = auth()->user()->id;
        $participant->item_it = $id;
        $participant->save();
        return redirect()->back()->with('success','Congrats! You have participated');
    }
}
