<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\admin\LuckyDrawItems;
use App\Models\User;
use App\Models\user\KYC;
use App\Models\user\LuckyParticipant;
use App\Models\user\UserBalance;
use App\Models\user\UserDeposit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LuckyDrawController extends Controller
{
    public function index()
    {
        $user = KYC::where('user_id', auth()->user()->id)->first();
        if (!$user || $user->status !== 'approved') {
            return redirect()->route('User.KYC')->with('error', 'You must complete KYC to participate in luckyDraw.');
        }

        $luck = LuckyDrawItems::get();
        return view('user.luckydraw.index', compact('luck'));
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
        $item = LuckyDrawItems::find($id);
        // check if user already participated
        $user_check = LuckyParticipant::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->first();
        if ($user_check) {
            return redirect()->back()->with('error', 'you have already participate in this lottery');
        }
        $user_balance = UserBalance::where('user_id', auth()->user()->id)->first();
        // limit
        if ($user_balance) {
            if ($user_balance->balance == 0) {
                return redirect()->back()->with('error', 'your account is empty');
            }
            if ($user_balance->balance < $item->amount) {
                return redirect()->back()->with('error', 'you have not enough balance');
            }
            // deduct balance from user balance
            $user_balance->balance -= $item->amount;
            $user_balance->save();
            // participate
            $participant = new LuckyParticipant();
            $participant->user_id = auth()->user()->id;
            $participant->user_email = auth()->user()->email;
            $participant->item_id = $item->id;
            $participant->image = $item->image;
            $participant->item_price = $item->amount;
            $participant->save();
        } else {
            return redirect()->back()->with('error', 'Please Add Balance into your account');
        }

        return redirect()->back()->with('success', 'Congrats! You have participated');
    }

    public function winner()
    {
        return view('user.luckydraw.winner');
    }
}
