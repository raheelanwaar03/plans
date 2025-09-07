<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\LuckyDrawItems;
use App\Models\user\LuckyParticipant;
use App\Models\user\UserBalance;
use App\Models\user\UserDeposit;
use Illuminate\Http\Request;

class AdminLuckyDrawController extends Controller
{
    public function add()
    {
        return view('admin.luckyDraw.add');
    }

    public function store(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'image' => 'required',
        ]);

        $luckyImage = rand(1111111, 99999999) . '.' . $request->image->extension();
        $request->image->move(public_path('images/luckyDraw'), $luckyImage);

        $luckyItems = new LuckyDrawItems();
        $luckyItems->name = $request->name;
        $luckyItems->amount = $request->amount;
        $luckyItems->image = $luckyImage;
        $luckyItems->save();
        return redirect()->back()->with('success', '' . $request->name . ' added successfully');
    }

    public function all()
    {
        $luckyItems = LuckyDrawItems::get();
        return view('admin.luckyDraw.all', compact('luckyItems'));
    }

    public function requests()
    {
        $deposit = UserDeposit::get();
        return view('admin.luckyDraw.deposit', compact('deposit'));
    }

    public function approveReq($id)
    {
        $deposit = UserDeposit::find($id);
        if ($deposit->status == 'pending') {
            $user = UserBalance::find($deposit->user_id);
            if ($user) {
                $user->balance += $deposit->amount;
                $user->save();
                // approve status
                $deposit->status = 'approved';
                $deposit->save();
                return redirect()->back()->with('success', 'Balance Approved');
            } else {
                $userBalance = new UserBalance();
                $userBalance->user_id = $deposit->user_id;
                $userBalance->balance = $deposit->amount;
                $userBalance->save();
                // approve status
                $deposit->status = 'approved';
                $deposit->save();
                return redirect()->back()->with('success', 'Balance Approved');
            }
        }
    }

    public function participante()
    {
        $participante = LuckyParticipant::get();
        return view('admin.luckyDraw.participant', compact('participante'));
    }

    public function winner($id)
    {
        $winner = LuckyParticipant::find($id);
        $winner->status = "winner";
        $winner->save();
        return redirect()->back()->with('success', '' . $winner->user_email . ' selected as a Winner');
    }

    public function delItem($id)
    {
        $item = LuckyDrawItems::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item Deleted');
    }
}
